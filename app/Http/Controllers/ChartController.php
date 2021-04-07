<?php

namespace App\Http\Controllers;

use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use App\Record;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function profiles($id) {
        $records = Record::where('user_id', Auth::id())->orderBy('date', 'desc')->paginate(21)->reverse();
        // dd($records);
        $dates = [];
        $words = [];
        $exercises = [];
        $repeats = [];
        foreach($records as $record) {
            $month = date('m', strtotime($record -> date));
            $day = date('d', strtotime($record -> date));
            if (substr($day, 0, 1) == '0')
                $day = substr($day, 1);
            switch ($month) {
                case '1':
                    $month = 'Stycznia';
                    break;
                case '2':
                    $month = 'Lutego';
                    break;
                case '3':
                    $month = 'Marca';
                    break;
                case '4':
                    $month = 'Kwietnia';
                    break;
                case '5':
                    $month = 'Maja';
                    break;
                case '6':
                    $month = 'Czerwca';
                    break;
                case '7':
                    $month = 'Lipca';
                    break;
                case '8':
                    $month = 'Sierpnia';
                    break;
                case '9':
                    $month = 'Września';
                    break;
                case '10':
                    $month = 'Października';
                    break;
                case '11':
                    $month = 'Listopada';
                    break;
                case '12':
                    $month = 'Grudnia';
                    break;
            }

            array_push($dates, $day.' '.$month);
            array_push($words, $record -> words);
            array_push($exercises, $record -> exercises);
            array_push($repeats, $record -> repeats);
        }

        if ($id == 1) {
            $chart = Chartisan::build()
            ->labels($dates)
            ->dataset('Dodanych słów', $words)
            ->toJSON();
        } else if ($id == 2) {
            $chart = Chartisan::build()
            ->labels($dates)
            ->dataset('Uzyskanych punktów', $exercises)
            ->toJSON();
        } else {
            $chart = Chartisan::build()
            ->labels($dates)
            ->dataset('Powtórzonych słów', $repeats)
            ->toJSON();
        }
        return $chart;
    }

    public function user($id, $user_id) {
        $records = Record::where('user_id', $user_id)->orderBy('date', 'desc')->paginate(21)->reverse();
        // dd($records);
        $dates = [];
        $words = [];
        $exercises = [];
        $repeats = [];

        foreach($records as $record) {
            $month = date('m', strtotime($record -> date));
            $day = date('d', strtotime($record -> date));
            if (substr($day, 0, 1) == '0')
                $day = substr($day, 1);
            switch ($month) {
                case '1':
                    $month = 'Stycznia';
                    break;
                case '2':
                    $month = 'Lutego';
                    break;
                case '3':
                    $month = 'Marca';
                    break;
                case '4':
                    $month = 'Kwietnia';
                    break;
                case '5':
                    $month = 'Maja';
                    break;
                case '6':
                    $month = 'Czerwca';
                    break;
                case '7':
                    $month = 'Lipca';
                    break;
                case '8':
                    $month = 'Sierpnia';
                    break;
                case '9':
                    $month = 'Września';
                    break;
                case '10':
                    $month = 'Października';
                    break;
                case '11':
                    $month = 'Listopada';
                    break;
                case '12':
                    $month = 'Grudnia';
                    break;
            }

            array_push($dates, $day.' '.$month);
            array_push($words, $record -> words);
            array_push($exercises, $record -> exercises);
            array_push($repeats, $record -> repeats);
        }

        if ($id == 1) {
            $chart = Chartisan::build()
            ->labels($dates)
            ->dataset('Dodanych słów', $words)
            ->toJSON();
        } else if ($id == 2) {
            $chart = Chartisan::build()
            ->labels($dates)
            ->dataset('Przeprowadzonych ćwiczeń', $exercises)
            ->toJSON();
        } else {
            $chart = Chartisan::build()
            ->labels($dates)
            ->dataset('Powtórzonych słów', $repeats)
            ->toJSON();
        }
        return $chart;
    }
}
