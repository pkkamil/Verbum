<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\WordsResource;
use App\Word;

class WordsApiController extends Controller
{
    public function paginate($items = 60) {
        return WordsResource::collection(Word::paginate($items));
    }

    public function search($q) {
        return WordsResource::collection(Word::where('word', 'like', '%'.$q.'%')->orWhere('translation', 'like', '%'.$q.'%')->get());
    }
}
