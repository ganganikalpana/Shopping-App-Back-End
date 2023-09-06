<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    public function Login(Request $request){
        $validator=Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>"inputs validation error",
                "data"=> $validator->messages(), 
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                "status"=>200,
                "message"=>"Success",
                "data"=>[
                    'name'=>$user['name'],
                    'access_token' => $token,
                ]
                ],200);
        }else{
            return response()->json([
                "status"=>401,
                "message" => 'Unauthorized']);
        }

        
        
    }

    public function Logout(Request $request){

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
