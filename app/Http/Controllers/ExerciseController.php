<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Exercise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNan;

class ExerciseController extends Controller
{
    public function index() {
        return view('exercises');
    }

    public function translation() {
        $words = Word::all();
        $rightWords = [];
        foreach($words as $w) {
            if (count($w -> remembered_by) == 0) {
                array_push($rightWords, $w);
            } else {
                if ($w -> remembered_by[0] -> id != Auth::id())
                    array_push($rightWords, $w);
            }
        }
        // randomize word
        $word = $rightWords[array_rand($rightWords)];
        $exercise = Exercise::where([['user_id', '=', Auth::id()], ['type', '=', 'translation']])->first();
        if (!$exercise) {
            Exercise::create([
                'type' => 'translation',
                'score' => 0,
                'user_id' => Auth::id()
            ]);
            $exercise = Exercise::where([['user_id', '=', Auth::id()], ['type', '=', 'translation']])->first();
        }
        $exercise -> score = $exercise -> score + 1;
        $exercise -> save();
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
        DB::table('user_word')->insert(
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
            $exercise = Exercise::where([['user_id', '=', Auth::id()], ['type', '=', 'matching']])->first();
            if (is_null($exercise)) {
                Exercise::create([
                    'type' => 'matching',
                    'score' => 0,
                    'user_id' => Auth::id()
                ]);
                $exercise = Exercise::where([['user_id', '=', Auth::id()], ['type', '=', 'matching']])->first();
            }
            $exercise -> score = $exercise -> score + $points;
            $exercise -> save();
            // dd('Uzyskano '.$points.' punktów');
            return view('exercise-matching', compact('results', 'words'));
        } else {
            $word = $req -> word;
            $translation = $req -> translation;
            if (strtolower($req -> answer) == $req -> word) {
                $exercise = Exercise::where([['user_id', '=', Auth::id()], ['type', '=', 'writing']])->first();
                if (!$exercise) {
                    Exercise::create([
                        'type' => 'writing',
                        'score' => 0,
                        'user_id' => Auth::id()
                    ]);
                    $exercise = Exercise::where([['user_id', '=', Auth::id()], ['type', '=', 'writing']])->first();
                }
                $exercise -> score = $exercise -> score + 1;
                $exercise -> save();
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
