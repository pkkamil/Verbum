<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Exercise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Record;
use App\Section;
use Illuminate\Support\Carbon;
use App\Log;

class ExerciseController extends Controller
{
    public function index($section_id = 0) {
        if ($section_id != 0) {
            $section = Section::where('id', $section_id)->where('user_id', Auth::id())->first();
            if ($section)
                return view('section-exercises')->with('section', $section);
            else
                return view('exercises');
        }
        return view('exercises');
    }

    public function translation($section_id = 0) {
        if ($section_id != 0) {
            $section = Section::where('id', $section_id)->where('user_id', Auth::id())->first();
            if ($section)
                $word = $section -> words -> random();
            else {
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
            }
        } else {
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
        }

        // Add Record
        $record = Record::whereDate('date', Carbon::Today())->where('user_id', Auth::id())->first();
        if (isset($record)) {
            $record -> repeats = $record -> repeats + 1;
            $record -> save();
        }

        // Check if exercise column exists
        $exercise = Exercise::where('user_id', Auth::id())->first();
        if (!$exercise) {
            Exercise::create([
                'user_id' => Auth::id()
            ]);
            $exercise = Exercise::where('user_id', Auth::id())->first();
        }
        $exercise -> translation = $exercise -> translation + 1;
        $exercise -> save();
        return view('exercise-translation', compact('word', 'section_id'));
    }

    public function matching($section_id = 0) {
        if ($section_id != 0) {
            $section = Section::where('id', $section_id)->where('user_id', Auth::id())->first();
            if ($section) {
                $words = $section -> words -> random(5);
                $w = [];
                foreach($words as $word) {
                    array_push($w, Word::find($word -> word_id));
                }
                $words = $w;
            } else {
                $words = Word::all()->random(5);
            }
        } else {
            $words = Word::all()->random(5);
        }
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
        return view('exercise-matching', compact('words', 'section_id'));
    }

    public function writing($section_id = 0) {
        if ($section_id != 0) {
            $section = Section::where('id', $section_id)->where('user_id', Auth::id())->first();
            if ($section) {
                $randomWord = Word::find($section -> words -> random() -> word_id);
                $word = $randomWord -> word;
                $translation = $randomWord -> translation;
            } else {
                $randomWord = Word::all() -> random();
                $word = $randomWord -> word;
                $translation = $randomWord -> translation;
            }
        } else {
            $randomWord = Word::all() -> random();
            $word = $randomWord -> word;
            $translation = $randomWord -> translation;
        }
        return view('exercise-writing', compact('word', 'translation', 'section_id'));
    }

    public function rememberWord(Request $req) {
        DB::table('user_word')->insert(
            ['word_id' => $req -> word, 'user_id' => Auth::id()]
        );

        // Add log
        $log = new Log;
        $log -> type = 16;
        $log -> user_id = Auth::id();
        $log -> type_id = $req -> word;
        $log -> save();

        return redirect()->back();
    }

    public function checkAnswer(Request $req) {
        if ($req -> A1) {
            $points = 0;
            $results = [];
            $keys = [];
            $values = [];
            foreach($req -> request as $i) {
                if ($i != $req -> _token) {
                    if ($i != $req -> section_id) {
                        $word = explode(' | ', $i)[0];
                        $translation = explode(' | ', $i)[1];
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
            }
            $words = array_combine($keys, $values);
            $exercise = Exercise::where('user_id', Auth::id())->first();
            if (is_null($exercise)) {
                Exercise::create([
                    'user_id' => Auth::id()
                ]);
                $exercise = Exercise::where('user_id', Auth::id())->first();
            }
            $exercise -> matching = $exercise -> matching + $points;
            $exercise -> save();
            // Add Record
            $record = Record::whereDate('date', Carbon::Today())->where('user_id', Auth::id())->first();
            if (isset($record)) {
                $record -> exercises = $record -> exercises + $points;
                $record -> save();
            }

            // Add log
            $log = new Log;
            $log -> type = 21;
            $log -> user_id = Auth::id();
            $log -> save();

            if ($req -> section_id)
                return view('exercise-matching', compact('results', 'words'), ['section_id' => $req -> section_id]);
            else
                return view('exercise-matching', compact('results', 'words'));
        } else {
            // Add log
            $log = new Log;
            $log -> type = 22;
            $log -> user_id = Auth::id();
            $log -> save();

            $word = $req -> word;
            $translation = $req -> translation;
            if (strtolower($req -> answer) == $req -> word) {
                $exercise = Exercise::where('user_id', Auth::id())->first();
                if (!$exercise) {
                    Exercise::create([
                        'user_id' => Auth::id()
                    ]);
                    $exercise = Exercise::where('user_id', Auth::id())->first();
                }
                $exercise -> writing = $exercise -> writing + 1;
                $exercise -> save();
                // Add Record
                $record = Record::whereDate('date', Carbon::Today())->where('user_id', Auth::id())->first();
                if (isset($record)) {
                    $record -> exercises = $record -> exercises + 1;
                    $record -> save();
                }
                $result = 'correct';
                if ($req -> section_id)
                    return view('exercise-writing', compact('word', 'translation', 'result'), ['section_id' => $req -> section_id]);
                else
                    return view('exercise-writing', compact('word', 'translation', 'result'));
            }
            else {
                $result = 'incorrect';
                if ($req -> section_id)
                    return view('exercise-writing', compact('word', 'translation', 'result'), ['section_id' => $req -> section_id]);
                else
                    return view('exercise-writing', compact('word', 'translation', 'result'));
            }
        }
    }
}
