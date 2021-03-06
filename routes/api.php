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
Route::get('/photos/{id}', 'ApiPhotoController@get')->name('photo_get');
Route::get('/photos/{id}/comments', 'ApiPhotoController@comments')->name('photo_comments');
Route::get('/users/{id}/photos', 'ApiUserController@photos')->name('user_photos');
Route::get('/users/{id}/favs', 'ApiUserController@favs')->name('user_favs');
Route::get('/users/{id}/timeline', 'ApiUserController@timeline')->name('user_timeline');
Route::get('/users/me', 'ApiUserController@me')->name('user_me');

Route::post('/image', 'ApiImageController@imageUpload')->name('image_upload');

Route::middleware(['auth'])->group(function () {
    Route::post('/users/{id}/followers', 'ApiFollowController@follow_add')->name('user_follow_add');
    Route::delete('/users/{id}/followers', 'ApiFollowController@follow_del')->name('user_follow_del');
    Route::post('/users/{id}/favs', 'ApiUserController@add_fav')->name('user_add_fav');
    Route::delete('/users/{id}/favs', 'ApiUserController@del_fav')->name('user_del_fav');
});
