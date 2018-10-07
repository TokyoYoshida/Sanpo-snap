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

Auth::routes();

Route::get('/', 'TopController@index')->name('top');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/resign', 'ResignController@show')->name('resign_show');
Route::post('/user/resign', 'ResignController@update')->name('resign_update');
Route::get('/user/resign_complete', 'ResignController@complete')->name('resign_complete_show');
Route::get('/user/edit', 'UserEditController@index')->name('user_edit');
Route::post('/user/edit/update', 'UserEditController@update');
Route::post('/user/edit/upload', 'UserEditController@upload');
Route::get('/user/password_change', 'PasswordChangeController@show')->name('password_change_show');
Route::post('/user/password_change', 'PasswordChangeController@update')->name('password_change_update');
Route::get('/user/{id}', 'UserEditController@show')->name('user_show');
Route::get('/photos/create', 'PhotoController@create')->name('photo_create');
Route::get('/photos/{id}', 'PhotoController@show')->name('photo_show');
Route::post('/photos', 'PhotoController@store')->name('photo_store');
Route::get('/photos/edit/{id}', 'PhotoController@edit')->name('photo_edit');
Route::post('/photos/edit/update', 'PhotoController@update')->name('photo_update');
Route::get('/user/{id}/follows', 'FollowController@follows')->name('follows_show');
Route::get('/user/{id}/followers', 'FollowController@follower')->name('follower_show');
Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
