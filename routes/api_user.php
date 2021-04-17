<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Apis
|--------------------------------------------------------------------------
*/


###################login and register routes

  


   Route::post('user/login','UserController@login');
   Route::post('user/register','UserController@register');


  

   ####################################
   Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('user/comments','CommentController@posts_index');
   Route::post('user/comments/add','CommentController@AddComment');
   Route::post('user/comments/update','CommentController@UpdateComment');
   Route::get('user/comments/delete/{comment_id}','CommentController@deleteComment');
    });
 
