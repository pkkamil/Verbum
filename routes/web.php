<?php

use Illuminate\Support\Facades\Auth;
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
Route::post('/', 'WordController@search')->name('searchWords');


// Auth

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/add-word', 'WordController@addPage');
    Route::get('/profile', 'UserController@index');
    Route::post('/add', 'SuggestionController@add')->name('addSuggestion');
    Route::get('/exercises', 'ExerciseController@index');

    Route::get('/exercises/translation', 'ExerciseController@translation');
    Route::get('/exercises/matching', 'ExerciseController@matching')->name('matching');
    Route::get('/exercises/writing', 'ExerciseController@writing');

    Route::post('/exercises/translation', 'ExerciseController@rememberWord')->name('rememberWord');
    Route::post('/exercises/matching', 'ExerciseController@checkAnswer')->name('checkAnswers');
    Route::post('/exercises/writing', 'ExerciseController@checkAnswer')->name('checkWord');

    Route::post('/profile/name', 'UserController@changeName')->name('changeName');
    Route::post('/profile/password', 'UserController@changePassword')->name('changePassword');
    Route::post('/profile/report', 'UserController@reportAnError')->name('reportAnError');
    Route::post('/profile/delete', 'UserController@destroy')->name('deleteAccount');
    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/users', 'UserController@list');
            Route::get('/words', 'WordController@list');
            Route::get('/suggestions', 'SuggestionController@list');

            Route::get('/users/{id}', 'UserController@details');
            Route::post('/user/edit/name', 'UserController@editUserName')->name('changeUserName');
            Route::post('/user/edit/email', 'UserController@editUserEmail')->name('changeUserEmail');
            Route::post('/user/delete', 'UserController@deleteUser')->name('deleteUserAccount');

            Route::get('/words/{id}', 'WordController@details');
            Route::get('/words/{id}/edit', 'WordController@edit');
            Route::post('/word/edit', 'WordController@editWordDetails')->name('changeWordDetails');
            Route::get('/words/{id}/delete', 'WordController@delete');

            Route::get('/suggestions/{id}', 'SuggestionController@details');
            Route::get('/suggestions/{id}/edit', 'SuggestionController@edit');
            Route::post('/suggestion/edit', 'SuggestionController@editSuggestionDetails')->name('changeSuggestionDetails');
            Route::get('/suggestions/{id_suggestion}/accept', 'SuggestionController@accept');
            Route::get('/suggestions/{id_suggestion}/replace', 'SuggestionController@replace');
            Route::get('/suggestions/{id}/delete', 'SuggestionController@delete');
        });
    });
    Route::get('/ranking/{type}', 'UserController@showRanking');
});

Route::view('/charts', 'charts');

Route::get('/charts/profile/{id}', 'ChartController@profiles');
