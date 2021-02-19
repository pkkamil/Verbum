<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;

class ExerciseController extends Controller
{
    public function index() {
        return view('exercises');
    }

    public function translation() {
        $word = Word::all()->random();
        return view('exercise-translation')->with('word', $word);
    }

    public function matching() {
        return view('exercise-matching');
    }

    public function writing() {
        $word = Word::all()->random();
        return view('exercise-writing')->with('word', $word);
    }

    public function rememberWord(Request $req) {

    }

    public function checkAnswer(Request $req) {
        if (strtolower($req -> answer) == $req -> word)
            dd('Gratulacje!');
        else
            dd('Niestety nie udalo sie!');
    }
}
