<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\WordsResource;
use App\Word;
use App\Suggestion;
use Illuminate\Support\Facades\Auth;

class WordsApiController extends Controller
{
    public function paginate($items = 60) {
        return WordsResource::collection(Word::paginate($items));
    }

    public function search($q) {
        return WordsResource::collection(Word::where('word', 'like', '%'.$q.'%')->orWhere('translation', 'like', '%'.$q.'%')->get());
    }

    public function createSuggestion(Request $req, $user_id) {
        // create Suggestion
        $word = new Suggestion();
        $word -> word = mb_strtolower($req -> word);
        $word -> translation = mb_strtolower($req -> translation);
        $word -> user_id = $user_id;
        $word -> save();
        return $word;
    }
}
