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

//Top
Route::get('/' ,'TopController@index')->name('index');

//Twitter
Route::get('/show_twitter' ,'TwitterController@show')->name('twitter.show');
Route::post('/store_twitter','TwitterController@store')->name('twitter.store');
Route::get('/check','TwitterController@check')->name('check');
Route::get('/reverse','TwitterController@reverse')->name('reverse');
Route::get('/favorite_list', 'TwitterController@favorite_list')->name('favorite_list');
// Auth Twitter
Route::get('auth/twitter', 'Auth\AuthController@TwitterRedirect')->name('auth.twitter');
Route::get('auth/twitter/callback', 'Auth\AuthController@TwitterCallback');
Route::get('auth/twitter/logout', 'Auth\AuthController@getLogout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
