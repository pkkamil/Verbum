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
        $words = Word::all()->random(5);
        $readyWords = [];
        $translation = [];
        $word = [];

        foreach($words as $w) {
            array_push($translation, $w -> translation);
            array_push($word, $w -> word);
        }

        $readyWords = array_combine($word, $translation);

        //randomize
        $keys = array_keys($readyWords);
        shuffle($keys);
        $values = array_values(($readyWords));
        $shuffled = array_combine($keys, $values);

        // shuffle($readyWords);
        // dd($shuffled, $readyWords);
        $words = $shuffled;
        return view('exercise-matching', compact('words'));
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
        if ($req -> answers) {

        } else {
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
}
