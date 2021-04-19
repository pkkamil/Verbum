import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:verbum/components/WordCard.dart';
import 'package:verbum/components/DedicatedButton.dart';
import 'package:verbum/pages/ListWords.dart';
import 'package:verbum/services/Api.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Words extends StatefulWidget {
  final Map response;
  Words(this.response);

  @override
  _WordsState createState() => _WordsState();
}

int wordsCount = 0;
List words;
List<WordInfo> wordCard;
bool _isLoading = true;

class _WordsState extends State<Words> {

  sendData(id) async{
    var api = new Api();
    var response = await api.wordsList(id);

    if (response['statusCode'] == 500) {
      SharedPreferences localStorage = await SharedPreferences.getInstance();
      localStorage.setString('userData', null);
      Navigator.popUntil(context, ModalRoute.withName(Navigator.defaultRouteName));
      Navigator.pushNamed(context, '/');
    }

    setState(() {
      _isLoading = true;
      if (response['statusCode'] == 200){
        words = response['body']['data'];
        wordsCount = words.length;
        if (wordsCount == null) {wordsCount=0;}
        wordCard = [];


        if (wordsCount != 0) {
          for (int i=0;i<wordsCount;i++) {
            wordCard.add(WordInfo(userId: widget.response['id']));
            wordCard[i].parseData(words[i]);
          }
        }
      }
    });
    //print(WordCard);
    _isLoading = false;
  }

  void setupData() async{
    await sendData(widget.response['id']);
  }

  @override
  void initState() {
    setupData();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {

    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
    Size size = MediaQuery.of(context).size;

    //if(flats_count==0){
    //Navigator.pushReplacementNamed(context, '/choice');
    //}

    if (_isLoading){
      return Scaffold(
          backgroundColor: Colors.grey[850],
          body: Center(
            child: SpinKitPulse(
              color: Colors.white,
              size: 100.0,
            ),
          )
      );
    } else {
      return Scaffold(
        body: SafeArea(
          child: Container(
            height: size.height,
            child: Stack(
              alignment: Alignment.center,
              children: [
                Positioned(
                    top: 30,
                    left: 30,
                    child: RichText(
                      text: TextSpan(
                          style: TextStyle(
                            color: Colors.grey[900],
                            fontSize: 24,
                          ),
                          children: [
                            TextSpan(text: "Witaj, "),
                            TextSpan(text: widget.response['name'], style: TextStyle(color: Colors.grey[850])),
                            TextSpan(text: "!"),
                          ]
                      ),
                    )
                ),
                Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      SizedBox(height: size.height*0.1),
                      if(wordsCount >= 1) WordCard(
                        wordName: (wordCard==null) ? 'Loading...' : wordCard[0].name,
                        size: size.width*0.51,
                        wordTranslation: (wordCard==null) ? 'Loading...' : wordCard[0],
                      ),

                      if(wordsCount > 1) WordCard(
                        wordName: (wordCard==null) ? 'Loading...' : wordCard[1].name,
                        size: size.width*0.51,
                        wordTranslation: (wordCard==null) ? 'Loading...' : wordCard[1],
                      ),

                      if(wordsCount > 2) DedicatedButton(
                        horizontal: 0.0,
                        width: size.width*0.7,
                        color: Colors.white,
                        textColor: Colors.grey[850],
                        onPress: () {
                          // Navigator.push(context,MaterialPageRoute(builder: (BuildContext context) => ListFlats(flatCard)));
                        },
                        text: "Zobacz więcej",
                      ),
                      //SizedBox(height: size.height*0.05),
                    ],
                  ),
                )
              ],
            ),
          ),
        ),
      );
    }
  }
}

class WordInfo{
  int userId;
  Map json;

  WordInfo({
    this.userId,
  });

  int wordId;

  String name;
  String translation;

  DateTime createdAt;
  DateTime updatedAt;

  void parseData(Map response) {
    createdAt = DateTime.parse(response['created_at']);
    updatedAt = DateTime.parse(response['updated_at']);

    userId = response['user_id'];
    wordId = response['id'];

    name = response['word'];
    translation = response['translation'];
  }
}