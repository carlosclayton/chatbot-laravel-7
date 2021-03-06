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

Route::get('/', function () {
    return view('welcome');
});


Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::match(['get', 'post'], '/telegram', 'TelegramController@handle');
Route::match(['get', 'post'], '/facebook', 'FacebookController@handle');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/privacy', function () {
    return 'Privacy';
});

Route::get('/rules', function () {
    return 'Rules';
});
