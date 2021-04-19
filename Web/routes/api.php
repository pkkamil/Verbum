<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('words/paginate/{items?}', 'api\WordsApiController@paginate');
Route::get('words/search/{q}', 'api\WordsApiController@search');
Route::post('suggestion/new/{user_id}', 'api\WordsApiController@createSuggestion');
