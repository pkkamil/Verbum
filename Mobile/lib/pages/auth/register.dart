import 'package:flutter/material.dart';
import 'package:verbum/components/DedicatedButton.dart';
import 'package:verbum/components/DedicatedInput.dart';
import 'package:verbum/components/ReturnButton.dart';
import 'package:flutter/services.dart';
import 'package:email_validator/email_validator.dart';

class Register extends StatefulWidget {

  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  final emailController = TextEditingController();

  final passwordController = TextEditingController();

  final repeatPasswordController = TextEditingController();


  @override
  void dispose(){
    emailController.dispose();
    passwordController.dispose();
    repeatPasswordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
    Size size = MediaQuery.of(context).size;

    return Scaffold(
      body: Builder(
          builder: (context) { return SingleChildScrollView(
            child: SafeArea(
              child: Container(
                width: size.width,
                height: size.height-60,
                child: Stack(
                    children: [
                      ReturnButton(),
                      Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Text(
                              "Rejestracja".toUpperCase(),
                              style: TextStyle(
                                  color: Colors.grey[850],
                                  fontSize: 32.0
                              ),
                            ),
                            SizedBox(height: size.height*0.05),
                            DedicatedInput(
                              controller: emailController,
                              width: size.width*0.7,
                              placeholder: "E-mail".toUpperCase(),
                              color: Colors.white,
                              textColor: Colors.black,
                              iconColor: Colors.black,
                              icon: Icons.mail,
                            ),
                            DedicatedInput(
                              controller: passwordController,
                              width: size.width*0.7,
                              placeholder: "Hasło".toUpperCase(),
                              password: true,
                              color: Colors.white,
                              textColor: Colors.black,
                              iconColor: Colors.black,
                              icon: Icons.lock,
                            ),
                            DedicatedInput(
                              controller: repeatPasswordController,
                              width: size.width*0.7,
                              placeholder: "Potwierdź hasło".toUpperCase(),
                              password: true,
                              color: Colors.white,
                              textColor: Colors.black,
                              iconColor: Colors.black,
                              icon: Icons.lock,
                            ),
                            SizedBox(height: size.height*0.02),
                            DedicatedButton(
                                text: "Zarejestruj się",
                                textColor: Colors.white,
                                color: Colors.grey[850].withOpacity(0.95),
                                onPress: (){
                                  //wykrycie czy wszystkie pola sa wypelniona plus sprawdzanie poprawnosci email

                                  if(emailController.text == '' || passwordController.text == '' || repeatPasswordController.text == ''){
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
                                  }else{
                                    if(passwordController.text.length<8){
                                      Scaffold.of(context).showSnackBar(
                                          SnackBar(
                                              backgroundColor: Colors.grey[850],
                                              content: Text(
                                                "Hasło powinno mieć minimum 8 znaków".toUpperCase(),
                                                textAlign: TextAlign.center,
                                                style: TextStyle(
                                                    fontSize: 18
                                                ),
                                              )
                                          )
                                      );
                                    }else{
                                      bool isEmail = EmailValidator.validate(emailController.text);
                                      if(passwordController.text==repeatPasswordController.text){
                                        if(isEmail){
                                          Navigator.popAndPushNamed(context, '/introduce', arguments: {
                                            'email': emailController.text,
                                            'password': passwordController.text,
                                            'password_confirmation':repeatPasswordController.text
                                          });

                                        }else{
                                          Scaffold.of(context).showSnackBar(
                                              SnackBar(
                                                  backgroundColor: Colors.grey[850],
                                                  content: Text(
                                                    "Niepoprawny adres e-mail".toUpperCase(),
                                                    textAlign: TextAlign.center,
                                                    style: TextStyle(
                                                        fontSize: 18
                                                    ),
                                                  )
                                              )
                                          );
                                        }

                                      }else{
                                        Scaffold.of(context).showSnackBar(
                                            SnackBar(
                                                backgroundColor: Colors.grey[850],
                                                content: Text(
                                                  "Hasła nie zgadzają się".toUpperCase(),
                                                  textAlign: TextAlign.center,
                                                  style: TextStyle(
                                                      fontSize: 18
                                                  ),
                                                )
                                            )
                                        );
                                      }
                                    }
                                  }
                                },
                                width: size.width*0.7
                            ),
                            SizedBox(height: size.height*0.02),
                            GestureDetector(
                              onTap: () {
                                Navigator.pushReplacementNamed(context, '/login');
                              },
                              child: Text(
                                "Masz już konto?".toUpperCase(),
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