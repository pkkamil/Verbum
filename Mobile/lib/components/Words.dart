import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:verbum/components/WordCard.dart';
import 'package:verbum/components/DedicatedButton.dart';
// import 'package:verbum/pages/ListWords.dart';
import 'package:verbum/services/Api.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Words extends StatefulWidget {
  final int items;
  Words(this.items);

  @override
  _WordsState createState() => _WordsState();
}

int wordsCount = 0;
List words;
List<WordInfo> wordCard;
bool _isLoading = true;

class _WordsState extends State<Words> {

  getWords(i) async{
    var api = new Api();
    var response = await api.wordsList(i);

    if (response['statusCode'] == 500) {
      SharedPreferences localStorage = await SharedPreferences.getInstance();
      localStorage.setString('userData', null);
      Navigator.popUntil(context, ModalRoute.withName(Navigator.defaultRouteName));
      Navigator.pushNamed(context, '/home');
    }

    setState(() {
      _isLoading = true;
      if (response['statusCode'] == 200) {
        words = response['body']['data'];
        wordsCount = words.length;
        if (wordsCount == null) {
          wordsCount = 0;
        }
        wordCard = [];

        if (wordsCount != 0) {
          for (int i = 0; i < wordsCount; i++) {
            wordCard.add(WordInfo());
            wordCard[i].parseData(words[i]);
          }
        }
      }
    });
    _isLoading = false;
  }

  @override
  void initState() {
    getWords(50);
    super.initState();
  }

  @override
  Widget build(BuildContext context) {

    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
    Size size = MediaQuery.of(context).size;

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
        backgroundColor: Colors.white,
        body: SingleChildScrollView(
          child: SafeArea(
            child: Container(
              margin: EdgeInsets.fromLTRB(0, 10, 0, 20),
              child: Stack(
                children: [
                  // Row(
                  //   mainAxisAlignment: MainAxisAlignment.center,
                  //   children: [
                  //     Text("Lista słów: ".toUpperCase(),
                  //       style: TextStyle(
                  //         fontWeight: FontWeight.w600,
                  //         color: Colors.grey[900],
                  //         fontSize: 28.0,
                  //       ),
                  //     ),
                  //   ],
                  // ),
                  Center(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        // SizedBox(height: 30.0),
                        for (int i = 0; i < wordsCount; i++) WordCard(
                          wordName: (wordCard==null) ? 'ładowanie...' : wordCard[i].name,
                          wordTranslation: (wordCard==null) ? 'ładowanie...' : wordCard[i].translation,
                        ),
                        DedicatedButton(
                          horizontal: 0.0,
                          width: size.width*0.6,
                          color: Colors.white,
                          textColor: Colors.grey[850],
                          onPress: () {
                            // Navigator.push(context,MaterialPageRoute(builder: (BuildContext context) => ListFlats(flatCard)));
                            getWords(wordsCount + 50);
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