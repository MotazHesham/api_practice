<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Apis
|--------------------------------------------------------------------------
*/

Route::post('user/login','UserController@login');
Route::post('user/register','UserController@register');

Route::group(['middleware'=>'auth:sanctum','prefix'=>'user/comments'],function(){
    Route::get('/', 'CommentController@index');
    Route::post('/add', 'CommentController@add');
    Route::post('/update', 'CommentController@update');
    Route::get('/delete/{id}', 'CommentController@delete');

});