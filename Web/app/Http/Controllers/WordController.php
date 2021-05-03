<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Record;
use App\Remembered;
use App\User;
use Browser;
use App\Log;
use App\Trash;

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
        return view('add-word');
    }

    public function remembered() {
        if (Browser::isTablet())
            $remembered = Remembered::where('user_id', Auth::id()) -> paginate(20);
        else
            $remembered = Remembered::where('user_id', Auth::id()) -> paginate(10);
        return view('remembered-list')->with('remembered', $remembered);
    }

    public function deleteRemembered(Request $req) {
        Remembered::where('user_id', Auth::id())->where('word_id', $req -> word_id)->delete();

        // Add log
        $log = new Log;
        $log -> type = 17;
        $log -> user_id = Auth::id();
        $log -> type_id = $req -> word_id;
        $log -> save();

        return redirect()->back();
    }

    public function list() {
        if (Browser::isTablet())
            $words = Word::paginate(20);
        else
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

        // Add log
        $log = new Log;
        $log -> type = 11;
        $log -> user_id = Auth::id();
        $log -> type_id = $word -> id;
        $log -> save();

        return redirect('/admin/words/'.$req -> word_id);
    }

    public function delete(Request $req) {
        // Remove Record
        $user = User::find(Word::find($req -> word_id) -> user_id);
        $record = Record::whereDate('date', Word::find($req -> word_id) -> updated_at)->where('user_id', $user -> id)->first();

        $user -> words = $user -> words - 1;
        $user -> save();

        if (isset($record)) {
            $record -> words = $record -> words - 1;
            $record -> save();
        }

        // Add log
        $log = new Log;
        $log -> type = 12;
        $log -> user_id = Auth::id();
        $log -> type_id = $req -> word_id;
        $log -> save();

        // Add to trash
        $trash = new Trash;
        $trash -> user_id = Word::find($req -> word_id) -> user_id;
        $trash -> type = 'word';
        $trash -> word = Word::find($req -> word_id) -> word;
        $trash -> translation = Word::find($req -> word_id) -> translation;
        $trash -> save();

        Word::destroy($req -> word_id);
        if (str_contains(url()->previous(), '/words?page'))
            return redirect()->back();
        return redirect('/admin/words');
    }
}
