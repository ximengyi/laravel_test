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
$middleware = ['accessTime', 'tobAuth'];

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task', 'TaskController@home');
Route::get('/task/send', 'TaskController@send');

Route::namespace('Account')->group(function() {
    // App\Http\Controllers\Admin\AdminController
    Route::get('/account/task', 'TaskController@home');
    Route::get('/account/test', 'TestController@home');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/session', 'HomeController@session')->name('session');


Route::group(['prefix' => '/welcome'], function () {

    Route::any('/getName', ['uses' => 'HomeController@getName'])->name('getName');
    Route::any('/getRedirectUrl', ['uses' => 'HomeLoginBeforeController@getRedirectUrl']);
    Route::any('/giveRedEnvelopes', ['uses' => 'HomeLoginBeforeController@giveRedEnvelopes']);
    Route::any('/validWechat', ['uses' => 'HomeLoginBeforeController@validWechat']);
    Route::any('/testMoney', ['uses' => 'HomeLoginBeforeController@testMoney']);



});