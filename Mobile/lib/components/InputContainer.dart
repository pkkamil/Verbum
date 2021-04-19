import 'package:flutter/material.dart';

class InputContainer extends StatelessWidget {
  final Widget child;
  final Color color;
  final width;
  const InputContainer({
    Key key,
    this.child,
    this.color,
    this.width
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(vertical: 10),
      padding: EdgeInsets.symmetric(horizontal: 20, vertical: 5),
      width: width,
      decoration: BoxDecoration(
        color: Colors.grey[300],
        border: Border.all(
          color: Colors.grey[900],
          width: 1,
        ),
      ),
      child: child,
    );
  }
}