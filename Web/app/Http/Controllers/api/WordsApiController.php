<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\WordsResource;
use App\Word;
use App\Suggestion;
use App\Section;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

class WordsApiController extends Controller
{
    public function paginate($items = 60) {
        return WordsResource::collection(Word::paginate($items));
    }

    public function search($q) {
        if ($q == '' || $q == 'undefined') {
            return WordsResource::collection((Word::all()));
        }
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

    public function sectionSearch($id, $q) {
        if ($q == '' || $q == 'undefined') {
            $words = Section::find($id) -> words;
            $w = [];
            foreach($words as $word) {
                array_push($w, Word::find($word -> word_id));
            }
            return WordsResource::collection($w);
        } else {
            $words = Section::find($id) -> words;
            $w = [];
            foreach($words as $word) {
                if (count(Word::where('id', $word -> word_id)->where('word', 'like', '%'.$q.'%')->get()) != 0)
                    array_push($w, Word::find($word -> word_id));
                else if (count(Word::where('id', $word -> word_id)->where('translation', 'like', '%'.$q.'%')->get()) != 0)
                    array_push($w, Word::find($word -> word_id));
            }
            return WordsResource::collection($w);
        }
    }

    public function sectionWords($id) {
        $words = Section::find($id) -> words;
        $w = [];
        foreach($words as $word) {
            array_push($w, Word::find($word -> word_id));
        }
        return WordsResource::collection($w);
    }
}