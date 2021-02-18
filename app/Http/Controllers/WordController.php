<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index() {
        $words = Word::all()->sortBy('word');
        return view('home')->with('words', $words);
    }

    public function addPage() {
        return view('addWord');
    }

    public function add(Request $req) {
        $req->validate([
            'word' => 'required|string|unique:words',
            'translation' => 'required|string',
        ]);
        // create word
        $word = new Word();
        $word -> word = $req -> word;
        $word -> translation = $req -> translation;
        $word -> save();
        if ($req -> action == 'exit')
            return redirect('/');
        else
            return view('addWord');
    }
}
