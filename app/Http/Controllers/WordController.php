<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index() {
        return view('addWord');
    }

    public function add(Request $req) {
        if ($req -> action == 'exit')
            return view('home');
        else
            return view('addWord');
    }
}
