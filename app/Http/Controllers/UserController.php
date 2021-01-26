<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ];

        $validator =Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors());
        } 
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $token = auth()->user()->createToken('User');
            return response()->json($token->plainTextToken);
        } else {
            return response()->json(__('invalid username or password'));
        } 
    }
}
