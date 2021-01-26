<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;







class AuthorController extends Controller
{


    public function register(Request $request)
    {
        $rules=[

            'first_name' => 'required|max: 255',
            'last_name' => 'required|max: 255',
            'email' => 'required|email',
            'password' => 'required|min:6|max :20',
        ];

        $validator =Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors());
        }


        $author = Author::create([
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

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ];

        $validator =Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $credentials = $request->only(['email', 'password']);
        $token = Auth::guard('author')->attempt($credentials);
        if (!$token){
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $author = Author::where('email', $request->email)->first();
        $authToken = $author->createToken('auth-token')->plainTextToken;

        return response()->json([
            'author_token' => $authToken,
        ]);
    }


}
