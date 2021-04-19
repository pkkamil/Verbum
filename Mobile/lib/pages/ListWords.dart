import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:verbum/components/WordCard.dart';
import 'package:verbum/components/DedicatedButton.dart';

class ListWords extends StatelessWidget {
  final List response;
  const ListWords(this.response);

  @override
  Widget build(BuildContext context) {

    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);

    Size size = MediaQuery.of(context).size;
    return Scaffold(
      body: SafeArea(
        child: Container(
          height: size.height,
          child: ListView(
            children: [
              Container(
                  margin: EdgeInsets.fromLTRB(30, 40, 0, 20),
                  child: Text(
                    'Słowa:'.toUpperCase(),
                    style: TextStyle(
                      color: Colors.grey[900],
                      fontSize: 24,
                    ),
                  )
              ),
              Container(
                  child: Column(
                    children: [
                      Center(
                        child: Column(
                          children: [
                            for(int i=0;i<response.length;i+=2) Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                WordCard(
                                  wordName: response[i].name,
                                  wordTranslation: response[i].translation,
                                  marginL: 10.0,
                                  marginR: 10.0,
                                  marginB: 10.0,
                                  marginT: 10.0,
                                  fontSize: 15.0,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                      SizedBox(height: size.height*0.02),
                      if(response.length%2==0) Column(
                        children: [
                          DedicatedButton(
                            width: size.width*0.7,
                            onPress: () {},
                            color: Colors.white,
                            textColor: Colors.grey[850],
                            text: "Pokaż więcej".toUpperCase(),
                          ),
                          SizedBox(height: size.height*0.05)
                        ],
                      ),
                    ],
                  )
              ),
            ],
          ),
        ),
      ),
    );
  }
}