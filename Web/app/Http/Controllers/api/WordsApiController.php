<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\WordsResource;
use App\Word;
use App\Suggestion;
use App\Section;
use App\Log;

class WordsApiController extends Controller
{
    public function paginate($items = 60) {
        return WordsResource::collection(Word::paginate($items));
    }

    public function paginateSectionWords($items = 60) {
        return WordsResource::collection(Word::orderByDesc('created_at')->paginate($items));
    }

    public function search($q) {
        if ($q == '' || $q == 'undefined') {
            return WordsResource::collection((Word::all()));
        }
        return WordsResource::collection(Word::where('word', 'like', '%'.$q.'%')->orWhere('translation', 'like', '%'.$q.'%')->get());
    }

    public function searchSectionWords($q) {
        if ($q == '' || $q == 'undefined') {
            return WordsResource::collection((Word::orderByDesc('created_at')->get()));
        }
        return WordsResource::collection(Word::where('word', 'like', '%'.$q.'%')->orWhere('translation', 'like', '%'.$q.'%')->orderByDesc('created_at')->get());
    }

    public function createSuggestion(Request $req, $user_id) {
        // create Suggestion
        $word = new Suggestion();
        $word -> word = mb_strtolower($req -> word);
        $word -> translation = mb_strtolower($req -> translation);
        $word -> user_id = $user_id;
        $word -> save();

        // Add log
        $log = new Log;
        $log -> type = 5;
        $log -> user_id = $user_id;
        $log -> type_id = $word -> id;
        $log -> save();

        return $word;
    }

    public function findSimilar($q) {
        return WordsResource::collection(Word::where('word', 'like', '%'.$q.'%')->get('word'));
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
