<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\post\PostResourse;
use Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
   public function index(){
      $post = Post::with('comments.user')->orderBy('created_at','desc')->paginate(2);

      $new = PostResourse::collection($post);

      return $this->returnPaginationData('posts',$new,$post);
   }   

   public function add(Request $request){
      
      $rules = [
         'title' => 'required|max:255',
         'description' => 'required',
      ];

      $validator =Validator::make($request->all(),$rules);

      if($validator->fails()){
            return response()->json($validator->errors());
      }

      $post = new Post; 
      $post->title = $request->title;
      $post->description = $request->description;
      $post->author_id = auth()->user()->id;
      if (request()->hasFile('image') && request('image') != ''){
         $validator = Validator::make($request->all(), [
               'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
         ]);
         if ($validator->fails()) {
               return response()->json($validator->errors(), 401);
         }
         $post->image = Storage::disk('public')->put('posts', $request->image);
      }
      $post->save();

      return response()->json(['message' => 'success']);
   }

   public function update(Request $request )
   {
      $rules = [
         'id' => 'required|integer',
      ];

      $validator =Validator::make($request->all(),$rules);

      if($validator->fails()){
         return response()->json($validator->errors());
      }
      // check if post exists
      $post= Post::find($request->id);

      if(!$post)
         return response()->json(['message' => 'error']);

      if (request()->title && request('title') != '' && request('title') != $post->title){
         $validator = Validator::make($request->all(), [
               'title' => 'required|max:255',
         ]);
         if ($validator->fails()) {
               return $this->returnError('401',$validator->errors());
         }
         $post->title = $request->title;
      }
      if (request()->description && request('description') != '' && request('description') != $post->description){
         $validator = Validator::make($request->all(), [
               'description' => 'required|max:255',
         ]);
         if ($validator->fails()) {
               return $this->returnError('401',$validator->errors());
         }
         $post->description = $request->description;
      }
      if (request()->hasFile('image') && request('image') != ''){
         $validator = Validator::make($request->all(), [
               'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
         ]);
         if ($validator->fails()) {
               return response()->json($validator->errors(), 401);
         }
         $post->image = Storage::disk('public')->put('posts', $request->image);
      }

      //update data
      $post -> save();


      return response()->json(['message' => 'success']);


   }
   
   public function delete(Request $request)
   {
      $post=Post::find($request->id);
      if(!$post)
      return response()->json(['error' => 'failed']);
      $post->delete();

      return response()->json(['message' => 'success']);

   }
   
   public function returnPaginationData($key,$value,$paginator, $msg = "")
   {
         return response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => $msg,
            'data' => $value,
            'pagination' => [
               'links' =>[
                     'first' => $paginator->url(1),
                     'last' => $paginator->url($paginator->lastPage()),
                     'prev' => $paginator->previousPageUrl(),
                     'next' => $paginator->nextPageUrl()
               ],
               'meta' => [
                     'current_page' => $paginator->currentPage(),
                     'from' => $paginator->firstItem(),
                     'to' => $paginator->lastItem(),
                     'last_page' => $paginator->lastPage(),
                     'total_items_in_current_page' => $paginator->count(),
                     'items_per_page' => $paginator->perPage(),
                     'total_pages' => $paginator->lastPage(),
                     'total_items' => $paginator->total()
               ]
            ]
         ]);
   }
}
