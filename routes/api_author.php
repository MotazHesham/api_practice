<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Author Apis
|--------------------------------------------------------------------------
*/


Route::post('author/login','AuthorController@login');
Route::post('author/register','AuthorController@register');

Route::group(['middleware'=>'auth:sanctum','prefix'=>'author/posts'],function(){
    Route::get('/', 'PostController@index');
    Route::post('/add', 'PostController@add');
    Route::post('/update', 'PostController@update');
    Route::get('/delete/{id}', 'PostController@delete');

});