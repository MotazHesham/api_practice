<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Apis
|--------------------------------------------------------------------------
*/

Route::post('login','UserController@login');

Route::post('add/comment','CommentController@add')->middleware('auth:sanctum');