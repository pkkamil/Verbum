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

Route::get('auth/google', 'Auth\LoginController@google');
Route::get('auth/google/callback', 'Auth\LoginController@googleRedirect');

// Auth

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/add-word', 'WordController@addPage');
    Route::get('/profile', 'UserController@index');
    Route::post('/add', 'SuggestionController@add')->name('addSuggestion');
    Route::get('/exercises/{section_id?}', 'ExerciseController@index');

    Route::get('/exercise/translation/{section_id?}', 'ExerciseController@translation');
    Route::get('/exercise/matching/{section_id?}', 'ExerciseController@matching')->name('matching');
    Route::get('/exercise/writing/{section_id?}', 'ExerciseController@writing');

    Route::post('/exercise/translation', 'ExerciseController@rememberWord')->name('rememberWord');
    Route::post('/exercise/matching', 'ExerciseController@checkAnswer')->name('checkAnswers');
    Route::post('/exercise/writing', 'ExerciseController@checkAnswer')->name('checkWord');

    Route::post('/profile/name', 'UserController@changeName')->name('changeName');
    Route::post('/profile/password', 'UserController@changePassword')->name('changePassword');
    Route::post('/profile/report', 'UserController@reportAnError')->name('reportAnError');
    Route::post('/profile/delete', 'UserController@destroy')->name('deleteAccount');

    Route::get('/profile/remembered', 'WordController@remembered')->name('rememberedList');
    Route::post('/profile/remembered/delete', 'WordController@deleteRemembered')->name('deleteRemembered');

    Route::get('/profile/sections/', 'SectionController@list');
    Route::get('/profile/section/create', 'SectionController@createPage');
    Route::post('/profile/section/create', 'SectionController@create')->name('createSection');
    Route::get('/profile/sections/{id}', 'SectionController@index');
    Route::get('/profile/section/{id}/edit', 'SectionController@editPage');
    Route::post('/profile/section/edit', 'SectionController@edit')->name('editSection');
    Route::post('/profile/section/delete', 'SectionController@destroy')->name('deleteSection');

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
            Route::post('/word/delete', 'WordController@delete')->name('deleteWord');

            Route::get('/suggestions/{id}', 'SuggestionController@details');
            Route::get('/suggestions/{id}/edit', 'SuggestionController@edit');
            Route::post('/suggestion/edit', 'SuggestionController@editSuggestionDetails')->name('changeSuggestionDetails');
            Route::post('/suggestions/accept', 'SuggestionController@accept')->name('acceptSuggestion');
            Route::post('/suggestion/replace', 'SuggestionController@replace')->name('replaceWord');
            Route::post('/suggestion/delete', 'SuggestionController@delete')->name('deleteSuggestion');

            Route::get('/reports', 'ReportController@list')->name('listReports');
            Route::get('/reports/{id}', 'ReportController@index');
            Route::post('/report/delete', 'ReportController@destroy')->name('deleteReport');
        });
    });
    Route::get('/ranking/{type}', 'UserController@showRanking');
});

Route::view('/charts', 'charts');

Route::get('/charts/profile/{id}', 'ChartController@profiles');
Route::get('/charts/user/{id}/{user_id}', 'ChartController@user');
