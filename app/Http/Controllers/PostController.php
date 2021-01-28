<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResourse;

class PostController extends Controller
{
   public function index(){
      $post = Post::with('comments.user')->paginate(2);

      $new = PostResourse::collection($post);

      return $this->returnPaginationData('posts',$new,$post);
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
