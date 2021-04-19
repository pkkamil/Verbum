import 'package:flutter/material.dart';
import 'package:verbum/components/DedicatedInput.dart';
import 'package:verbum/components/DedicatedButton.dart';
import 'package:verbum/components/DedicatedButton.dart';
import 'package:flutter/services.dart';
import 'package:verbum/components/ReturnButton.dart';
// import 'package:verbum/services/api.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Login extends StatelessWidget {

  final emailController = TextEditingController();
  final passwordController = TextEditingController();

  final _scaffoldKey = GlobalKey<ScaffoldState>();

  @override
  void dispose(){
    emailController.dispose();
    passwordController.dispose();
  }

  @override
  Widget build(BuildContext context) {
    sendData(data) async{

      // var api = new Api();
      // var response = await api.login(data);
      //
      // if(response['email']==null){
      //   _scaffoldKey.currentState.showSnackBar(
      //       SnackBar(
      //           backgroundColor: Colors.orange,
      //           content: Text(
      //             'Podano błędne dane logowania',
      //             textAlign: TextAlign.center,
      //             style: TextStyle(
      //                 fontSize: 18
      //             ),
      //           )
      //       )
      //   );
      // }

    //   try{
    //     if(response['email'].toLowerCase()==data['email'].toLowerCase()){
    //
    //       //Jezeli nie ma zweryfikowanego maila popandpushnamed do verificate
    //       SharedPreferences localStorage = await SharedPreferences.getInstance();
    //       localStorage.setString('userData', jsonEncode(response));
    //
    //       Navigator.popUntil(context, ModalRoute.withName(Navigator.defaultRouteName));
    //       Navigator.push(context,MaterialPageRoute(builder: (BuildContext context) => Flats(response)));
    //
    //
    //     }else{
    //       Scaffold.of(context).showSnackBar(
    //           SnackBar(
    //               backgroundColor: Colors.orange,
    //               content: Text(
    //                 "Musisz wypełnić wszystkie pola",
    //                 textAlign: TextAlign.center,
    //                 style: TextStyle(
    //                     fontSize: 18
    //                 ),
    //               )
    //           )
    //       );
    //     }
    //   }catch(e){
    //     print(e);
    //   }
    }

    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
    Size size = MediaQuery.of(context).size;

    return Scaffold(
      key: _scaffoldKey,
      backgroundColor: Colors.white,
      body: Builder(
          builder: (context) { return SingleChildScrollView(
            child: SafeArea(
              child: Container(
                height: size.height-100.0,
                child: Stack(
                    children: [
                      ReturnButton(),
                      Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Text(
                              "Logowanie".toUpperCase(),
                              style: TextStyle(
                                  color: Colors.grey[850],
                                  fontSize: 32.0
                              ),
                            ),
                            SizedBox(height:size.height*0.05),
                            DedicatedInput(
                              controller: emailController,
                              width: size.width*0.7,
                              placeholder: "Adres email".toUpperCase(),
                              color: Colors.white,
                              textColor: Colors.grey[850],
                              iconColor: Colors.grey[850],
                              icon: Icons.mail,
                            ),
                            DedicatedInput(
                              controller: passwordController,
                              width: size.width*0.7,
                              placeholder: "Hasło".toUpperCase(),
                              password: true,
                              color: Colors.white,
                              textColor: Colors.grey[850],
                              iconColor: Colors.grey[850],
                              icon: Icons.lock,
                            ),
                            SizedBox(height: size.height*0.02),
                            DedicatedButton(
                                text: "Zaloguj się",
                                color: Colors.grey[850].withOpacity(0.95),
                                textColor: Colors.white,
                                onPress: (){
                                  if (emailController.text == '' || passwordController.text ==''){
                                    Scaffold.of(context).showSnackBar(
                                        SnackBar(
                                            backgroundColor: Colors.grey[850],
                                            content: Text(
                                              "Musisz wypełnić wszystkie pola".toUpperCase(),
                                              textAlign: TextAlign.center,
                                              style: TextStyle(
                                                  fontSize: 18
                                              ),
                                            )
                                        )
                                    );
                                  } else{
                                    Map data = {
                                      'email': emailController.text,
                                      'password': passwordController.text
                                    };
                                    sendData(data);
                                  }
                                },
                                width: size.width*0.6
                            ),
                            SizedBox(height: size.height*0.02),
                            GestureDetector(
                              onTap: () {
                                Navigator.pushReplacementNamed(context, '/register');
                                },
                              child: Text(
                                "Nie masz jeszcze konta?".toUpperCase(),
                                style: TextStyle(
                                    color: Colors.grey[800],
                                    fontSize: 20
                                ),
                              ),
                            )
                          ],
                        ),
                      )]
                ),
              ),
            ),
          );}
      ),
    );
  }
}