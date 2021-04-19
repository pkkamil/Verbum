import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:flutter/services.dart';
import 'package:verbum/components/DedicatedButton.dart';

class Home extends StatelessWidget{
  @override

  Widget build(BuildContext context) {
    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
    Size size = MediaQuery.of(context).size;

    return Scaffold(
        backgroundColor: Colors.white,
        body: SafeArea(
          child: Padding(
            padding: EdgeInsets.symmetric(vertical: 160.0, horizontal: 40.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: <Widget>[
                Center(
                  child: Text(
                    'Verbum'.toUpperCase(),
                    style: TextStyle(
                      fontSize: 42.0,
                      color: Colors.grey[850],
                      letterSpacing: 1.5,
                    ),
                  ),
                ),
                SizedBox(
                  height: 100.0,
                ),
                DedicatedButton(
                    text: "Zaloguj się",
                    color: Colors.grey[850].withOpacity(0.95),
                    textColor: Colors.white,
                    marginV: 0.0,
                    onPress: () {
                      Navigator.pushNamed(context, '/login');
                    },
                    width: size.width*0.7,
                ),
                SizedBox(
                  height: 15.0,
                ),
                DedicatedButton(
                  text: "Zarejestruj się",
                  color: Colors.grey[850].withOpacity(0.95),
                  textColor: Colors.white,
                  marginV: 0.0,
                  onPress: () {
                    Navigator.pushNamed(context, '/register');
                  },
                  width: size.width*0.7,
                ),
                SizedBox(
                  height: 15.0,
                ),
                DedicatedButton(
                  text: "Google",
                  color: Colors.grey[850].withOpacity(0.95),
                  textColor: Colors.white,
                  marginV: 0.0,
                  onPress: () {
                    Navigator.pushNamed(context, '/register');
                  },
                  width: size.width*0.7,
                ),
                SizedBox(
                  height: 10.0,
                ),
                TextButton(
                  onPressed: () {},
                  child: Text(
                    'Pomiń'.toUpperCase(),
                    style: TextStyle(
                      color: Colors.grey[850],
                      fontSize: 18.0,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
    );
  }
}