<?php

namespace App\Http\Controllers;

use App\Word;
use App\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function index() {
        $words = Word::all()->sortBy('word');
        return view('home')->with('words', $words);
    }

    public function search(Request $req) {
        $words = Word::where('word', 'like', '%'.$req -> q.'%')->orWhere('translation', 'like', '%'.$req -> q.'%')->get();
        $q = $req -> q;
        return view('home', compact('words', 'q'));
    }

    public function addPage() {
        return view('addWord');
    }

    public function add(Request $req) {
        $req->validate([
            // 'word' => 'required|string|unique:word',
            'word' => 'required|string',
            'translation' => 'required|string',
        ]);

        // create Suggestion
        $word = new Suggestion();
        $word -> word = $req -> word;
        $word -> translation = $req -> translation;
        $word -> user_id = Auth::id();
        $word -> save();
        if ($req -> action == 'exit')
            return redirect('/');
        else
            return view('addWord');
    }
}
