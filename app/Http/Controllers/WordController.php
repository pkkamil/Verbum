<?php

namespace App\Http\Controllers;

use App\Word;
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

    public function list() {
        $words = Word::paginate(10);
        return view('words-list')->with('words', $words);
    }

    public function details($id) {
        $word = word::find($id);
        if (!$word) {
            return redirect()->back();
        }
        return view('word-details')->with('word', $word);
    }

    public function edit($id) {
        $word = word::find($id);
        if (!$word) {
            return redirect()->back();
        }
        return view('word-edit')->with('word', $word);
    }

    public function editWordDetails(Request $req) {
        $req->validate([
            'word' => 'required|string',
            'translation' => 'required|string',
        ]);

        // edit word
        $word = Word::find($req -> word_id);
        $word -> word = mb_strtolower($req -> word);
        $word -> translation = mb_strtolower($req -> translation);
        $word -> save();
        return redirect('/admin/words/'.$req -> word_id);
    }

    public function delete(Request $req) {
        Word::destroy($req -> word_id);
        if (str_contains(url()->previous(), '/words?page'))
            return redirect()->back();
        return redirect('/admin/words');
    }
}
