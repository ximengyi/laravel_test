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
// $middleware = ['accessTime', 'tobAuth'];
//
Route::get('/', function () {
    return view('welcome');
});




// Route::get('/task/send', 'TaskController@send');
//
// Route::npace('Account')->group(function() {
//     // App\Http\Controllers\Admin\AdminController
//     Route::get('/account/task', 'TaskController@home');
//     Route::get('/account/test', 'TestController@home');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/session', 'HomeController@session')->name('session');
//
//
//
//
//     // App\Http\Controllers\Admin\AdminController
// Route::get('notLogin', 'LoginController@notLogin')->name('notLogin');
//
//
//
// Route::group(['prefix' => '/welcome'], function () {
//
//     Route::any('/getName', ['uses' => 'HomeController@getName'])->name('getName');
//     Route::any('/getRedirectUrl', ['uses' => 'HomeLoginBeforeController@getRedirectUrl']);
//     Route::any('/giveRedEnvelopes', ['uses' => 'HomeLoginBeforeController@giveRedEnvelopes']);
//     Route::any('/validWechat', ['uses' => 'HomeLoginBeforeController@validWechat']);
//     Route::any('/testMoney', ['uses' => 'HomeLoginBeforeController@testMoney']);
//
//
//
// });
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/client', ['uses'=>'HomeController@client']);
Route::any('/form', 'HomeController@uploadForm');
Route::any('/server', 'HomeController@upLoadFileServer');


Route::get('/task', 'TaskController@home');




Route::get('/testweb', function () {
    return 'Hello, World!';
});

// 关于我们
Route::get('about', function () {
    return view('about');
});

// 产品页
Route::get('products', function () {
    return view('products');
});



