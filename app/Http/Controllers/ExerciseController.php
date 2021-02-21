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
        $randomWord = Word::all()->random();
        $word = $randomWord -> word;
        $translation = $randomWord -> translation;
        // dd($word -> word, $word -> translation);
        return view('exercise-writing', compact('word', 'translation'));
    }

    public function rememberWord(Request $req) {

    }

    public function checkAnswer(Request $req) {
        $word = $req -> word;
        $translation = $req -> translation;
        if (strtolower($req -> answer) == $req -> word) {
            $result = 'correct';
            return view('exercise-writing', compact('word', 'translation', 'result'));
        }
        else {
            $result = 'incorrect';
            return view('exercise-writing', compact('word', 'translation', 'result'));
        }
    }
}
