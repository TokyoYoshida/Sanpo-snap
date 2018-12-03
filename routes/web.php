<?php

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

Auth::routes(['verify' => true]);

Route::middleware('verified')->group(function() {
    Route::get('/vue/{vue_capture?}', function () {
        return view('layouts.vue');
    })->where('vue_capture', '[\/\w\.-]*');
    Route::get('/photos/create', 'PhotoController@create')->name('photo_create');
    Route::get('/photos/edit/{id}', 'PhotoController@edit')->name('photo_edit');
    Route::post('/photos/{id}/delete', 'PhotoController@destroy')->name('photo_delete');
    Route::post('/photos/edit/update', 'PhotoController@update')->name('photo_update');
    Route::get('/users/edit', 'UserEditController@index')->name('user_edit');
    Route::post('/users/edit/update', 'UserEditController@update');
    Route::post('/users/edit/upload', 'UserEditController@upload');
    Route::post('/photos', 'PhotoController@store')->name('photo_store');
});
Route::get('/login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('/', 'TopController@index')->name('top');
Route::get('/users/resign', 'ResignController@show')->name('resign_show');
Route::post('/users/resign', 'ResignController@update')->name('resign_update');
Route::get('/users/resign_complete', 'ResignController@complete')->name('resign_complete_show');
Route::get('/users/password_change', 'PasswordChangeController@show')->name('password_change_show');
Route::post('/users/password_change', 'PasswordChangeController@update')->name('password_change_update');
Route::get('/users/{id}', 'UserEditController@show')->name('user_show');
Route::get('/users/{id}/follows', 'FollowController@follows')->name('follows_show');
Route::get('/users/{id}/followers', 'FollowController@follower')->name('follower_show');
Route::get('/photos/{id}', 'PhotoController@show')->name('photo_show');
