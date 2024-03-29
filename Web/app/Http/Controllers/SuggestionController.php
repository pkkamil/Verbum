<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use Illuminate\Support\Facades\Auth;
use App\Word;
use App\User;
use App\Record;
use Browser;
use App\Log;
use App\Trash;

class SuggestionController extends Controller
{
    public function add(Request $req) {
        $req->validate([
            'word' => 'required|string|max:255',
            'translation' => 'required|string|max:255',
        ]);

        // create Suggestion
        $word = new Suggestion();
        $word -> word = mb_strtolower($req -> word);
        $word -> translation = mb_strtolower($req -> translation);
        $word -> user_id = Auth::id();
        $word -> save();

        // Add log
        $log = new Log;
        $log -> type = 5;
        $log -> user_id = Auth::id();
        $log -> type_id = $word -> id;
        $log -> save();

        if ($req -> action == 'exit')
            return redirect('/');
        else
            return view('add-word');
    }

    public function list() {
        if (Browser::isTablet())
            $suggestions = Suggestion::paginate(20);
        else
            $suggestions = Suggestion::paginate(9);
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

        // Add log
        $log = new Log;
        $log -> type = 8;
        $log -> user_id = Auth::id();
        $log -> type_id = $suggestion -> id;
        $log -> save();

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
        $word -> user_id = $suggestion -> user_id;
        $word -> save();

        // Add log
        $log = new Log;
        $log -> type = 6;
        $log -> user_id = Auth::id();
        $log -> type_id = $word -> id;
        $log -> save();

        return redirect('/admin/suggestions/');
    }

    public function acceptAll(Request $req) {
        $suggestions = Suggestion::all();

        foreach($suggestions as $suggestion) {
            if (!Word::where('word', $suggestion -> word)->first()) {
                $user = User::find($suggestion -> user_id);
                $user -> words = $user -> words + 1;
                $user -> save();

                // Add Record
                $record = Record::whereDate('date', $suggestion -> added_at)->where('user_id', $suggestion -> user_id)->first();
                if (isset($record)) {
                    $record -> words = $record -> words + 1;
                    $record -> save();
                }

                Suggestion::destroy($suggestion -> id);

                // create Word
                $word = new Word();
                $word -> word = $suggestion -> word;
                $word -> translation = $suggestion -> translation;
                $word -> user_id = $suggestion -> user_id;
                $word -> save();

                // Add log
                $log = new Log;
                $log -> type = 6;
                $log -> user_id = Auth::id();
                $log -> type_id = $word -> id;
                $log -> save();
            }
        }
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

        // Add log
        $log = new Log;
        $log -> type = 7;
        $log -> user_id = Auth::id();
        $log -> type_id = $word -> id;
        $log -> save();

        Suggestion::destroy($req -> suggestion_id);

        // Replace Word
        $word = Word::find($word -> id);
        $word -> word = $suggestion -> word;
        $word -> translation = $suggestion -> translation;

        // Decrease words
        $user = User::find($word -> user_id);
        if ($user -> user_id != $suggestion -> user_id) {
            $user -> words = $user -> words - 1;
            $user -> save();

            $record = Record::whereDate('date', $word -> updated_at)->where('user_id', $user -> user_id)->first();

            if (isset($record)) {
                $record -> words = $record -> words - 1;
                $record -> save();
            }
        }

        $word -> user_id = $suggestion -> user_id;
        $word -> save();
        return redirect('/admin/words/'.$word -> id);
    }

    public function delete(Request $req) {
        // Add log
        $log = new Log;
        $log -> type = 9;
        $log -> user_id = Auth::id();
        $log -> type_id = $req -> suggestion_id;
        $log -> save();

        // Add to trash
        $trash = new Trash;
        $trash -> user_id = Suggestion::find($req -> suggestion_id) -> user_id;
        $trash -> type = 'suggestion';
        $trash -> word = Suggestion::find($req -> suggestion_id) -> word;
        $trash -> translation = Suggestion::find($req -> suggestion_id) -> translation;
        $trash -> save();

        Suggestion::destroy($req -> suggestion_id);
        if (str_contains(url()->previous(), '/suggestions?page'))
            return redirect()->back();
        return redirect('/admin/suggestions');
    }
}
