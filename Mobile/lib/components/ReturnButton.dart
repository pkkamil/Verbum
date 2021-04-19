import 'package:flutter/material.dart';

class ReturnButton extends StatelessWidget {

  final String location;
  final bool pop;
  final bool isLeft;

  const ReturnButton({
    Key key,
    this.location = "/",
    this.pop = true,
    this.isLeft = true
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    if(isLeft){
      return Positioned(
          top: 0,
          left: 10,
          child: Container(
              margin: EdgeInsets.symmetric(horizontal: 15,vertical: 30),
              child: ClipRRect(
                child: FlatButton(
                    onPressed:  () {
                      if(pop){
                        Navigator.pop(context);
                      }else{
                        Navigator.popAndPushNamed(context, location);
                      }
                    },
                    color: Colors.grey[850],
                    child: Text(
                      "Wróć".toUpperCase(),
                      style: TextStyle(
                        fontWeight: FontWeight.normal,
                        color: Colors.white,
                        fontSize: 14,
                      ),
                    )
                ),
              )
          )
      );
    }else{
      return Positioned(
          top: 0,
          right: 10,
          child: Container(
              margin: EdgeInsets.symmetric(horizontal: 15,vertical: 30),
              child: ClipRRect(
                child: FlatButton(
                    onPressed:  () {
                      if(pop){
                        Navigator.pop(context);
                      }else{
                        Navigator.popAndPushNamed(context, location);
                      }
                    },
                    color: Colors.grey[850],
                    child: Text(
                      "Wróć".toUpperCase(),
                      style: TextStyle(
                        fontWeight: FontWeight.normal,
                        color: Colors.white,
                        fontSize: 14,
                      ),
                    )
                ),
              )
          )
      );
    }
  }
}