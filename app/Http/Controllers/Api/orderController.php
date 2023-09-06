<?php

namespace App\Http\Controllers\Api;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    protected $paymentService;

    // public function __construct(PaymentService $paymentService)
    // {
    //     $this->paymentService = $paymentService;
    // }

    //new order
    public function store($productid,Request $request){
        $validator=Validator::make($request->all(),[
            'discount'=>'required|integer',
            'total'=>'required|integer',
            'delivery_status'=>'required|string',   
            'payment_type'=>'required|string'    
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $order=Orders::create([
                "user_id"=>$request->user()->id,
                "product_id"=>$productid,
                "discount"=>$request['discount'],
                "total"=>$request['total'],
                "delivery_status"=>$request['delivery_status'],
                "payment_type"=>$request['payment_type'],
            ]);
    
            if($order){
                return response()->json([
                        'status'=>200,
                        'message'=>'Ordered successfully',
                        200  
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    errors=>'something went wrong!'
                ], 500 );               
            }
        }      
    }

    //edit order delivery status (admin only)
    public function update($orderid,Request $request){
        $validator=Validator::make($request->all(),[
            'discount'=>'required|integer',
            'total'=>'required|integer',
            'delivery_status'=>'required|string',   
            'payment_type'=>'required|string'    
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $order=Orders::find($orderid);
            
            if (!$order){
                return response()->json (['status'=>404,'message'=>'order not found',404 ]);
            }

            $order->update([
                "discount"=>$request['discount'],
                'total'=>$request['total'],
                'delivery_status'=>$request['delivery_status'],   
                'payment_type'=>$request['payment_type']    
            ]);
           
            return response()->json (['status'=>200,'message'=>'Success','data'=>$order,404 ]);
        }
    }

    //view all orders by user id
    public function showAllOrdersByUserId(Request $request){
        $userid=$request->user()->id;
        $orders=Orders::where('user_id', $userid)->get();

        if ($orders->isEmpty()){
            return response()->json (['status'=>404,'message'=>'orders not found under this user',404 ]);
        }

        return response()->json (['status'=>200,'message'=>'Success','data'=>$orders,200 ]);
    }

    //view order by order id
    public function show($orderid,Request $request){
        $order=Orders::find($orderid);

        if (!$order){
            return response()->json (['status'=>404,'message'=>'order not found',404 ]);
        }

        return response()->json (['status'=>200,'message'=>'Success','data'=>$order,200 ]);
    }

    public function index(Request $request){
        $orders=Orders::all();

        if ($orders->isEmpty()){
            return response()->json (['status'=>404,'message'=>'orders not found',404 ]);
        }

        return response()->json (['status'=>200,'message'=>'Success','data'=>$orders,200 ]);
    }
}
