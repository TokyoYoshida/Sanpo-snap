<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/photos', 'ApiPhotoController@index')->name('photo_index');
Route::get('/users/{id}/photos', 'ApiUserController@photos')->name('user_photos');
Route::get('/users/{id}/favs', 'ApiUserController@favs')->name('user_favs');

Route::post('/photo_image', 'ApiPhotoController@imageUpload')->name('photo_image_upload');

Route::middleware(['auth'])->group(function () {
    Route::post('/users/{id}/followers', 'ApiFollowController@follow')->name('user_follow');
});
