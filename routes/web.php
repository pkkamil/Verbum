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

Route::get('/', 'HomeController@index')->name('home');

// Auth

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/add-word', 'WordController@index');
    Route::post('/add', 'WordController@add')->name('addWord');
    Route::get('/exercises', 'ExerciseController@index');
});
