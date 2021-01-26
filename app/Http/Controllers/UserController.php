<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //
   
    public function login(Request $request){
        //valdite email and password

        $rules=[

            'email'=>'required|email',
            'password'=>'required',

        ];
        $validator =Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors());
 
        }
 
$credentials = $request -> only(['email','password']) ;
  //serch in user by email and password
$token =  Auth::guard('web') -> attempt($credentials);

if(!$token)
return response()->json('invaild username or password');

  $user = Auth::guard('api_user') -> user();
  $user -> api_token = $token;
  return $user->createToken('auth-token')->plainTextToken;
    }
    public function register(Request $request){



        $rules=[

            'email'=>'required|email|unique:users',
            'first_name'=>'required|max:255|string',
            'last_name'=>'required|max:255|string',
            'password'=>'required|min:6|max:20',

        ];
        $validator =Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json($validator->errors());
        }



        $user=User::create([
             'email'=>$request->email,
             'first_name'=>$request->first_name,
              'last_name'=>$request->last_name,
             'password'=>Hash::make($request->password),


        ]);
        return $user->createToken('auth-token')->plainTextToken;


}
 

}