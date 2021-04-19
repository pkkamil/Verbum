import 'package:flutter/material.dart';
import 'package:verbum/pages/home.dart';
import 'package:verbum/pages/loading.dart';
import 'package:verbum/pages/auth/login.dart';
import 'package:verbum/pages/auth/register.dart';

void main() => runApp(MaterialApp(
  initialRoute: '/home',
  routes: {
    '/': (context) => Loading(),
    '/home': (context) => Home(),
    '/login': (context) => Login(),
    '/register': (context) => Register(),
  },
));


