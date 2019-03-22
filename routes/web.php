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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task', 'TaskController@home');

Route::namespace('Account')->group(function() {
    // App\Http\Controllers\Admin\AdminController
    Route::get('/account/task', 'TaskController@home');
    Route::get('/account/test', 'TestController@home');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
