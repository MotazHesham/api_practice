<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Author Apis
|--------------------------------------------------------------------------
*/


Route::post('author/login','AuthorController@login');


Route::get('author/post/index', 'PostController@index')->middleware('auth:sanctum');
Route::get('author/comment/index', 'CommentController@index')->middleware('auth:sanctum');