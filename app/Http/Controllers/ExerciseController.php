<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::table('word_user')->insert(
            ['word_id' => $req -> word, 'user_id' => Auth::id()]
        );
        return redirect()->back();
    }

    public function checkAnswer(Request $req) {
        if ($req -> A1) {
            $points = 0;
            $results = [];
            $keys = [];
            $values = [];
            // dd($req -> _token);
            foreach($req -> request as $i) {
                if ($i != $req -> _token) {
                    $word = explode(' | ', $i)[0];
                    $translation = explode(' | ', $i)[1];
                    // print($word.' - '.$translation.' [] ');
                    $correct = Word::where('word', $word) -> first();
                    if ($correct -> translation == $translation) {
                        $points++;
                        $singleRecord = [];
                        $singleRecord = array('score' => 'correct', 'word' => $word, 'translation' => $translation);
                        array_push($results, $singleRecord);
                    } else {
                        $singleRecord = [];
                        $singleRecord = array('score' => 'incorrect', 'word' => $word, 'translation' => $translation);
                        array_push($results, $singleRecord);
                    }
                    array_push($keys, $correct -> word);
                    array_push($values, $correct -> translation);
                }
            }
            // dd($results);
            $words = array_combine($keys, $values);
            // dd('Uzyskano '.$points.' punktów');
            return view('exercise-matching', compact('results', 'words'));
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
