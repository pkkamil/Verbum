import 'package:flutter/material.dart';

class WordCard extends StatelessWidget {
  const WordCard({
    Key key,
    this.size,
    this.wordName,
    this.wordTranslation,
    this.fontSize = 18.0,
    this.marginL= 20.0,
    this.marginT= 20.0,
    this.marginR= 20.0,
    this.marginB= 20.0
  }) : super(key: key);

  final size;
  final wordName;
  final wordTranslation;
  final fontSize;
  final marginL,marginT,marginR,marginB;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.fromLTRB(marginL, marginT, marginR, marginB),
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 8),
        width: size,
        height: size,
        child: Center(
          child: Column(
            children: [
              Text(
                (wordName).toUpperCase(),
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.grey[850],
                  fontWeight: FontWeight.w500,
                  fontSize: 24.0,
                ),
              ),
              Text(
                wordTranslation,
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.grey[850],
                  fontWeight: FontWeight.w400,
                  fontSize: 21.0,
                ),
              )
            ],
          )
        ),
      )
    );
  }
}