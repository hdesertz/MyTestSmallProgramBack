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
Route::get('/', 'HomeController@index')->name('home');
Route::prefix("web")->group(function(){
    Route::post('login', 'HomeController@login');
    Route::get('create', 'HomeController@create');
    Route::post('createPost', 'HomeController@createPost');
    Route::get('post/{id}', 'HomeController@post')
        ->where('id', '[0-9]+');

});


Route::prefix("tool")->group(function(){
    Route::get('verifyCode', 'ToolController@verifyCode')
        ->name('verifyCode');
});



