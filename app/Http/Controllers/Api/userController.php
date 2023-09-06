<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function storeAdmin(Request $request){
        $request['role']=1;
        return $this->store($request);
    }

    public function storeCustomer(Request $request){
        $request['role']=0;
        return $this->store($request);
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',  
            'password'=>'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $user=User::create([
                "name"=>$request['name'],
                "email"=>$request['email'],
                "phone"=> $request["phone"],
                "password" => Hash::make($request->password),
                "role"=>$request['role']
            ]);

            if($user){
                return response()->json([
                    'status'=>201,
                    'message'=>'user added successfully',
                    201 
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    "errors"=>'something went wrong!'
                    ], 500 );
            }
           
        }
    }

    public function index(){
        $users=User::all();

        if($users->isEmpty()){
            return response()->json([
                'status'=>404,
                "errors"=>'Not found!'
                ], 404 );
        }

        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>$users,
            200
        ]);
    }

    public function show($userid){
        $user=User::find($userid);

        if(!$user){
            return response()->json([
                'status'=>404,
                "errors"=>'Not found!'
                ], 404 );
        }
        
        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>$user,
            200
        ]);
    }

    public function delete($userid){
        $user=User::find($userid);

        if(!$user){
            return response()->json([
                'status'=>404,
                "errors"=>'Not found!'
                ], 404 );
        }
        $user->delete();
        return response()->json([
            'status'=>200,
            'message'=>'success',
            200
        ]);
    }

}
