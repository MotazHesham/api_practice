<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\comment\CommentResourse2;
use Validator;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::with('post.author')->orderBy('created_at', 'desc')->paginate(2);

        $new = CommentResourse2::collection($comment);

        return $this->returnPaginationData('comments', $new, $comment);
    }

    public function add(Request $request)
    {

        $rules = [
            'comment' => 'required|max:255',
            'post_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return response()->json(['message' => 'success']);
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // check if post exists
        $comment = Comment::find($request->id);

        if (!$comment) {
            return response()->json(['message' => 'error']);
        }

        if (request()->comment && request('comment') != '' && request('comment') != $comment->comment) {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                return $this->returnError('401', $validator->errors());
            }
            $comment->comment = $request->comment;
        }
        //update data
        $comment->save();

        return response()->json(['message' => 'success']);

    }

    public function delete(Request $request)
    {
        $comment = Comment::find($request->id);
        if (!$comment) {
            return response()->json(['error' => 'failed']);
        }

        $comment->delete();

        return response()->json(['message' => 'success']);

    }

    public function returnPaginationData($key, $value, $paginator, $msg = "")
    {
        return response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => $msg,
            'data' => $value,
            'pagination' => [
                'links' => [
                    'first' => $paginator->url(1),
                    'last' => $paginator->url($paginator->lastPage()),
                    'prev' => $paginator->previousPageUrl(),
                    'next' => $paginator->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                    'last_page' => $paginator->lastPage(),
                    'total_items_in_current_page' => $paginator->count(),
                    'items_per_page' => $paginator->perPage(),
                    'total_pages' => $paginator->lastPage(),
                    'total_items' => $paginator->total(),
                ],
            ],
        ]);
    }
}
