import 'package:flutter/material.dart';

class DedicatedButton extends StatelessWidget {
  final String text;
  final Function onPress;
  final Color color, textColor;
  final width;
  final fontsize;
  final vertical;
  final horizontal;
  final marginV;
  final marginH;
  final bool isShadow;

  const DedicatedButton({
    this.text,
    this.onPress,
    this.color = Colors.black,
    this.textColor = Colors.grey,
    this.width,
    this.fontsize = 22.0,
    this.vertical = 20.0,
    this.horizontal = 0.0,
    this.marginV = 10.0,
    this.marginH = 0.0,
    this.isShadow = false,
    Key key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(vertical: marginV, horizontal: marginH),
      width: width,
      decoration: BoxDecoration(
        border: Border.all(
          color: Colors.grey[900],
          width: 2.0,
        ),
        color: Colors.grey[850],
        boxShadow: [
          if(isShadow) BoxShadow(
            color: color.withOpacity(0.5),
            spreadRadius: 3,
            blurRadius: 4,
            offset: Offset(0, 1),
          ),
        ],

      ),
      child:FlatButton(
          padding: EdgeInsets.symmetric(vertical: vertical, horizontal: horizontal),
          onPressed: onPress,
          child: Text(
            text.toUpperCase(),
            style: TextStyle(
              fontWeight: FontWeight.normal,
              color: Colors.white,
              fontSize: fontsize,
            ),
          )
      ),
    );
  }
}