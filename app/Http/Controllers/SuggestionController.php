<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use Illuminate\Support\Facades\Auth;
use App\Word;
use App\User;
use App\Record;

class SuggestionController extends Controller
{
    public function add(Request $req) {
        $req->validate([
            // 'word' => 'required|string|unique:word',
            'word' => 'required|string',
            'translation' => 'required|string',
        ]);

        // create Suggestion
        $word = new Suggestion();
        $word -> word = mb_strtolower($req -> word);
        $word -> translation = mb_strtolower($req -> translation);
        $word -> user_id = Auth::id();
        $word -> save();
        if ($req -> action == 'exit')
            return redirect('/');
        else
            return view('addWord');
    }

    public function list() {
        $suggestions = Suggestion::paginate(10);
        return view('suggestions-list')->with('suggestions', $suggestions);
    }

    public function details($id) {
        $suggestion = Suggestion::find($id);
        $duplicate = Word::where('word', $suggestion -> word)->first();
        if (!$suggestion) {
            return redirect()->back();
        }
        return view('suggestion-details', compact('suggestion', 'duplicate'));
    }

    public function edit($id) {
        $suggestion = Suggestion::find($id);
        if (!$suggestion) {
            return redirect()->back();
        }
        return view('suggestion-edit')->with('suggestion', $suggestion);
    }


    public function editSuggestionDetails(Request $req) {
        $req->validate([
            'word' => 'required|string',
            'translation' => 'required|string',
        ]);

        // edit suggestion
        $suggestion = Suggestion::find($req -> suggestion_id);
        $suggestion -> word = mb_strtolower($req -> word);
        $suggestion -> translation = mb_strtolower($req -> translation);
        $suggestion -> save();
        return redirect('/admin/suggestions/'.$req -> suggestion_id);
    }

    public function accept(Request $req) {
        $suggestion = Suggestion::find($req -> suggestion_id);
        if (count(Word::where('word', $suggestion -> word)->get()) != 0) {
            return redirect('/admin/suggestions/'.$suggestion -> id);
        }

        $user = User::find($suggestion -> user_id);
        $user -> words = $user -> words + 1;
        $user -> save();

        // Add Record
        $record = Record::whereDate('date', $suggestion -> added_at)->where('user_id', $suggestion -> user_id)->first();
        if (isset($record)) {
            $record -> words = $record -> words + 1;
            $record -> save();
        }

        Suggestion::destroy($req -> suggestion_id);

        // create Word
        $word = new Word();
        $word -> word = $suggestion -> word;
        $word -> translation = $suggestion -> translation;
        $word -> save();
        return redirect('/admin/suggestions/');
    }

    public function replace(Request $req) {
        $suggestion = Suggestion::find($req -> suggestion_id);
        $word = Word::where('word', $suggestion -> word)->first();

        $user = User::find($suggestion -> user_id);
        $user -> words = $user -> words + 1;
        $user -> save();

        // Add Record
        $record = Record::whereDate('date', $suggestion -> added_at)->where('user_id', $suggestion -> user_id)->first();
        if (isset($record)) {
            $record -> words = $record -> words + 1;
            $record -> save();
        }

        Suggestion::destroy($req -> suggestion_id);

        // Replace Word
        $word = Word::find($word -> id);
        $word -> word = $suggestion -> word;
        $word -> translation = $suggestion -> translation;
        $word -> save();
        return redirect('/admin/words/'.$word -> id);
    }

    public function delete(Request $req) {
        Suggestion::destroy($req -> suggestion_id);
        if (str_contains(url()->previous(), '/suggestions?page'))
            return redirect()->back();
        return redirect('/admin/suggestions');
    }
}
