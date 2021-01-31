<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class UserController extends Controller
{
    public function login(Request $request){
        if(!Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
                'success' => false,
                'status' => 200
            ]);
        }

        $user = Auth::guard('web')->user();

        $token = $user->createToken('user');

        return response()->json([
            'author_token' => $token->plainTextToken,
        ]);
    }

    public function register(Request $request)
    {
        $rules=[

            'first_name' => 'required|max: 255',
            'last_name' => 'required|max: 255',
            'email' => 'required|email|unique:authors,email',
            'password' => 'required|min:6|max:20',
        ];

        $validator =Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors());
        }


        $author = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


        $authToken = $author->createToken('auth-token')->plainTextToken;

        return response()->json([
            'author_token' => $authToken,
        ]);

    }

}
