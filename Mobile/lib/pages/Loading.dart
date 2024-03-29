import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:verbum/components/Words.dart';
import 'package:verbum/services/Api.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Loading extends StatefulWidget {
  @override
  _LoadingState createState() => _LoadingState();
}

final _scaffoldKey = GlobalKey<ScaffoldState>();

class _LoadingState extends State<Loading> {

  void checkConnection() async {
    try{
      Response response = await get(Uri.parse("$api"+'api/words'));
      if (response.statusCode == 200) {
        setupWelcomeScreen();
      }
    }
    catch(e){
      //Dodać snackBar
      _scaffoldKey.currentState.showSnackBar(
          SnackBar(
              duration: Duration(seconds: 5),
              backgroundColor: Colors.grey[850],
              content: Text(
                'Brak połączenia z internetem',
                textAlign: TextAlign.center,
                style: TextStyle(
                    fontSize: 18
                ),
              )
          )
      );
      print("Wystąpił błąd");
    }
  }

  void setupWelcomeScreen() async{
    await Future.delayed(Duration(seconds: 1));
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var userData = localStorage.getString('userData');

    //print('######');
    //print(userData);
    //print('######');

    if(userData==null){
      Navigator.pushReplacementNamed(context, '/');
    }else{
      Map response = jsonDecode(userData);
      Navigator.pushReplacement(context, MaterialPageRoute(builder: (BuildContext context) => Words(15)));
    }
  }

  @override
  void initState() {
    super.initState();
    //setupWelcomeScreen();
    checkConnection();
  }
  @override
  Widget build(BuildContext context) {
    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
    return Scaffold(
        key: _scaffoldKey,
        backgroundColor: Colors.grey[850],
        body: Center(
          child: SpinKitPulse(
            color: Colors.white,
            size: 100.0,
          ),
        )
    );
  }
}