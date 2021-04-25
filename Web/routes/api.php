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

Route::get('section/paginate/{items?}', 'api\WordsApiController@paginateSectionWords');
Route::get('section/search/{q}', 'api\WordsApiController@searchSectionWords');
Route::get('section/{id}/words', 'api\WordsApiController@sectionWords');
Route::get('section/{id}/search/{q}', 'api\WordsApiController@sectionSearch');

Route::post('login', 'api\AuthController@login');
Route::post('register', 'api\AuthController@register');
