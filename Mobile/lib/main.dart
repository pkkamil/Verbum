import 'package:flutter/material.dart';
import 'package:verbum/pages/Home.dart';
import 'package:verbum/pages/Loading.dart';
import 'package:verbum/pages/auth/Login.dart';
import 'package:verbum/pages/auth/Register.dart';
import 'package:verbum/components/Words.dart';

Map data = {
  'id':0,
  'name':'Disconnected'
};
List example;
WordInfo wordInfo;

void main() => runApp(MaterialApp(
  initialRoute: '/home',
  routes: {
    '/': (context) => Loading(),
    '/home': (context) => Home(),
    '/login': (context) => Login(),
    '/register': (context) => Register(),
    '/words':(context) => Words(data),
  },
));


