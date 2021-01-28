<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthorController extends Controller
{
    public function login(Request $request){
        if(!Auth::guard('author')->attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
                'success' => false,
                'status' => 200
            ]);
        }

        $user = Auth::guard('author')->user();

        $token = $user->createToken('user');

        return response()->json([
            'author_token' => $token->plainTextToken,
        ]);
    }
}
