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
      decoration: BoxDecoration(
          boxShadow: [
            BoxShadow(
              color: Colors.grey.withOpacity(0.4),
              spreadRadius: 5,
              blurRadius: 7,
              offset: Offset(0, 3),
            ),
          ]
      ),
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 8),
        width: size,
        height: size,
        child: Center(
          child: RichText(
            text: TextSpan(
              style: TextStyle(
                fontSize: fontSize,
                color: Colors.grey[850],
              ),
              children: [
                TextSpan(text: wordName.toUpperCase()),
                TextSpan(text: wordTranslation.toUppercase()),
              ]
            ),
          ),
        ),
      )
    );
  }
}