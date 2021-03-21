<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use Illuminate\Support\Facades\Auth;
use App\Word;
use App\User;

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
        $suggestions = Suggestion::paginate(9);
        return view('suggestions-list')->with('suggestions', $suggestions);
    }

    public function details($id) {
        $suggestion = Suggestion::find($id);
        $duplicate = Word::where('word', $suggestion -> word)->first();
        if (!$suggestion) {
            return redirect(url()->previous());
        }
        return view('suggestion-details', compact('suggestion', 'duplicate'));
    }

    public function edit($id) {
        $suggestion = Suggestion::find($id);
        if (!$suggestion) {
            return redirect(url()->previous());
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

    public function accept($id_suggestion) {
        $suggestion = Suggestion::find($id_suggestion);
        if (count(Word::where('word', $suggestion -> word)->get()) != 0) {
            return redirect('/admin/suggestions/'.$suggestion -> id);
        }

        $user = User::find($suggestion -> user_id);
        $user -> words = $user -> words + 1;
        $user -> save();

        Suggestion::destroy($id_suggestion);

        // create Word
        $word = new Word();
        $word -> word = $suggestion -> word;
        $word -> translation = $suggestion -> translation;
        $word -> save();
        return redirect('/admin/words/'.$word -> id);
    }

    public function replace($id_suggestion) {
        $suggestion = Suggestion::find($id_suggestion);
        $word = Word::where('word', $suggestion -> word)->first();
        Word::destroy($word -> id);

        $user = User::find($suggestion -> user_id);
        $user -> words = $user -> words + 1;
        $user -> save();

        Suggestion::destroy($id_suggestion);

        // create Word
        $word = new Word();
        $word -> word = $suggestion -> word;
        $word -> translation = $suggestion -> translation;
        $word -> save();
        return redirect('/admin/words/'.$word -> id);
    }

    public function delete($id) {
        Suggestion::destroy($id);
        return redirect('/admin/suggestions');
    }
}
