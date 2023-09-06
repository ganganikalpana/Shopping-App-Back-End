<?php

namespace App\Http\Controllers\Api;

use App\Models\Payments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class paymentController extends Controller
{
    //make payment
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'payment_type'=>'required|string',
            'status'=>'required|string',
            'amount'=>'required|integer',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $payment=Payments::create([
                'payment_type'=>$request['payment_type'],
                'status'=>$request['status'],
                "amount"=>$request['amount'],
            ]);

            if($payment){
                return response()->json([
                    'status'=>200,
                    'message'=>'payment successfully',
                    200  
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    errors=>'something went wrong!'
                    ], 500 
                );           
            }
        }
    }

    //view payment (only admin)
    public function show($payment_id){
        $payment=payments::find($payment_id);

        if($payment){
            return response()->json([
                'status'=>200,
                'message'=>$payment,
                200  
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'message'=>'something went wrong!'
                ], 500 
            );  
        }
    }
}
