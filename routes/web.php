<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WordController@index')->name('home');

// Auth

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/add-word', 'WordController@addPage');
    Route::get('/profile', 'UserController@index');
    Route::post('/add', 'WordController@add')->name('addWord');
    Route::get('/exercises', 'ExerciseController@index');

    Route::get('/exercises/translation', 'ExerciseController@translation');
    Route::get('/exercises/matching', 'ExerciseController@matching');
    Route::get('/exercises/writing', 'ExerciseController@writing');

    Route::post('/exercises/remember/word', 'ExerciseController@rememberWord')->name('rememberWord');

    Route::post('/exercises/writing', 'ExerciseController@checkAnswer')->name('checkWord');
});
