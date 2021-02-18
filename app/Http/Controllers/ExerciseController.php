<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index() {
        return view('exercises');
    }

    public function translation() {
        return view('exercise-translation');
    }

    public function matching() {
        return view('exercise-matching');
    }

    public function writing() {
        return view('exercise-writing');
    }

    public function rememberWord(Request $req) {

    }
}
