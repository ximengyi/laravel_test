<?php

use Illuminate\Http\Request;
use App\Article;
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
$middleware = ['web'];
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('posts', 'PostController');

//Route::post('articles','ArticleController@store');
Route::resource('articles', 'ArticleController');



Route::group(['prefix' => '/home','middleware' => $middleware], function () {
    Route::any('/getName', 'HomeController@getName');
  //  Route::any('/session', 'HomeController@session');
    Route::any('/session', ['uses' => 'HomeController@session']);
    //Route::any('/getName', ['uses' => 'HomeController@getName']);
    Route::any('/getRedirectUrl', ['uses' => 'HomeLoginBeforeController@getRedirectUrl']);
    Route::any('/giveRedEnvelopes', ['uses' => 'HomeLoginBeforeController@giveRedEnvelopes']);
    Route::any('/validWechat', ['uses' => 'HomeLoginBeforeController@validWechat']);
    Route::any('/testMoney', ['uses' => 'HomeLoginBeforeController@testMoney']);



});



































// Route::get('articles', function() {
//     // If the Content-Type and Accept headers are set to 'application/json',
//     // this will return a JSON structure. This will be cleaned up later.
//     return Article::all();
// });
//
// Route::get('articles/{id}', function($id) {
//     return Article::find($id);
// });
//
// Route::post('articles', function(Request $request) {
//     return Article::create($request->all);
// });
//
// Route::put('articles/{id}', function(Request $request, $id) {
//     $article = Article::findOrFail($id);
//     $article->update($request->all());
//
//     return $article;
// });
//
// Route::delete('articles/{id}', function($id) {
//     Article::find($id)->delete();
//
//     return 204;
// });