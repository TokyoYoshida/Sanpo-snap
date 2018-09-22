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
Route::get('/user/edit', 'UserEditController@index')->name('user_edit');
Route::post('/user/edit/update', 'UserEditController@update');
Route::post('/user/edit/upload', 'UserEditController@upload');
Route::get('/user/{id}', 'UserEditController@show')->name('user_show');
Route::get('/photos/create', 'PhotoController@create')->name('photo_create');
Route::post('/photos', 'PhotoController@store')->name('photo_store');
Route::get('/photos/edit/{id}', 'PhotoController@edit')->name('photo_edit');
Route::post('/photos/edit/update', 'PhotoController@update')->name('photo_edit');
