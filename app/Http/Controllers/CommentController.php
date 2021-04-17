<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Post;
use App\Comment;
use App\User;
use Illuminate\Http\Request;
class CommentController extends Controller
{
    //


    public function posts_index(){
       
        $all=Comment::with('Post.author')->paginate(4);
        
        
        $all->each(function($post){
        
            unset($post->post_id);
            unset($post->user_id);
            unset($post->id);
            
        });
  
 
        
        return response()->json([
          $all
        ]);
}
//------------------------------------------
public function AddComment(Request $request){

    //valdite comment
    $rules=[

        'comment'=>'required|max:255',
        'post_id'=>'required|integer',
       

    ];
    $validator =Validator::make($request->all(),$rules);

    if($validator->fails()){
        return response()->json($validator->errors());
    }
    
    $post=Post::find($request->post_id);
    $post->users()->attach(auth()->user()->id,['comment' => $request->comment]);
    
return response()->json('Your Comment added sucessfully');
     
}
//---------------------------------------------------------------------
public function UpdateComment(Request $request){

    $rules=[

        'comment'=>'max:255',
        'id'=>'required|integer',
       

    ];
    $validator =Validator::make($request->all(),$rules);

    if($validator->fails()){
        return response()->json($validator->errors());
    }

  $comment=Comment::find($request->id)->update($request -> all());
  return response()->json( "Your Comment updated sucessfully");


}

//----------------------------------------------
public function deleteComment ($id){
    
    $result=Comment::find($id);
    if(!$result)
    return response()->json( "this comment alredy deleted");  
    $result->delete();
    return response()->json( "Your Comment deleted sucessfully");
}
}