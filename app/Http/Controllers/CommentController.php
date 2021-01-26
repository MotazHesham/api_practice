<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class CommentController extends Controller
{
    public function add(Request $request){
        // $post = Post::with(['users' => function($query){
        //     $query->select('first_name','last_name','email');
        // }])->find($request->post_id);
        $posts = Post::paginate(10);
        //$post->users()->attach(auth()->user()->id,['comment' => $request->comment]);
        return response()->json($posts);
    }
}
