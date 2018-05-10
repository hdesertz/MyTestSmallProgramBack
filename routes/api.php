<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
Route::namespace("api")->group(function(){
    Route::post("user/login","UserController@login");
    Route::post("user/register","UserController@register");

    Route::get("post/getCategoryList","PostController@getCategoryList");
    Route::get("post/getPosts","PostController@getPosts");
    Route::get("post/getPost","PostController@getPost");
    Route::post("post/toggleCollectPost","PostController@toggleCollectPost");
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

