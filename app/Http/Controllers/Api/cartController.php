<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class cartController extends Controller
{
    //add to cart
    public function addToCart($productid,Request $request){
        $validator=Validator::make($request->all(),[
            'quantity'=>'required|integer',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $userid=$request->user()->id;

            if (Cart::where('user_id', $userid)->where('product_id', $productid)->first()){
                return response()->json(['status'=>500,'message'=>'Product is already added to the cart',500 ]);
            };

            $item=Cart::create([
                "user_id"=>$userid,
                "product_id"=>$productid,
                'quantity'=>$request->input("quantity"),
            ]);
        
            if($item){
                return response()->json([
                    'status'=>200,
                    'message'=>'added to cart successfully',
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

    //remove from cart
    public function removeFromCart($itemId,Request $request){
        $userid=$request->user()->id;
        $item=Cart::find($itemId);

        if (!$item){
            return response()->json(['status'=>404,'message'=>'product not found in cart',404 ]);
        }else{
            $item->delete();
            return response()->json([
                'status'=>200,
                'message'=>'deleted from cart successfully',
                200  
            ]);
        };
    }

    //view cart by user id
    public function getCartContents($itemId,Request $request){
        $item=Cart::find($itemId);

        if (!$item){
            return response()->json(['status'=>404,'message'=>'product not found in cart',404 ]);
        }else{
            return response()->json([
                'status'=>200,
                'data'=>$item,
                200  
            ]);
        };
    }
    
    public function updateCart($itemId,Request $request){
        $validator=Validator::make($request->all(),[
            'quantity'=>'required|integer',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $item=Cart::find($itemId);

            if (!$item){
                return response()->json(['status'=>404,'message'=>'product not found in cart',404 ]);
            }

            $item->quantity = $request['quantity'];  
            $item->save();
            return response()->json([
                    'status'=>200,
                    'data'=>$item,
                    200  
            ]);
        }     
    }

    public function index(Request $request){
        $userid=$request->user()->id;
        $items=Cart::where('user_id', $userid)->get();

        if ($items->isEmpty()){
            return response()->json (['status'=>404,'message'=>'products not found in cart',404 ]);
        }else{
            return response()->json([
                'status'=>200,
                'message'=>'successful',
                'data'=>$items,
                200  
            ]);
        };
    }
}
