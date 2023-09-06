<?php

namespace App\Http\Controllers\Api;

use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'price'=>'required|integer',
            'stock'=>'required|integer',   
            'availability'=>'required|string'    
        ]);


        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                422  
            ]);
        }else{
            $product=products::create([
                "name"=>$request['name'],
                "price"=>$request['price'],
                "stock"=> $request["stock"],
                "availability"=> $request["availability"],
                "user_id"=>$request->user()->id
            ]);

            if($product){
                return response()->json([
                    'status'=>200,
                    'message'=>'product added successfully',
                    200  
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    "errors"=>'something went wrong!'
                ], 503 );
            }    
        }
    }

    public function remove($productid,Request $request){
        $product= products::find($productid);

        if($request->user()->id===$product['user_id']){
            $product->delete();
            return response()->json([
                'status'=>200,
                'message'=>'deleted!'
                ], 200 );
        }
        
        return response()->json([
            'status'=>500,
            "errors"=>'unAuthorized!'
            ], 503 );
    }

    public function update($productid,Request $request){  
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'price' => 'required|integer',
                'stock' => 'required|integer',   
                'availability' => 'required|string'    
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ], 422);
            }
        
            $product = products::find($productid);
        
            if (!$product) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product not found'
                ], 404);
            }
        
            $product->update([
                "name" => $request['name'],
                "price" => $request['price'],
                "stock" => $request["stock"],
                "availability" => $request["availability"]
            ]);
        
            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully',
                'product'=>$product,
            ], 200);
                        
    }

    public function show($productid){
        $product=products::find($productid);

        if($product){
            return response()->json([$product]);
        }else{
            return response()->json([
                'status'=>404,
                'errors'=>'not found!'
                ], 404 );
        }     
    }

    public function index(Request $request){
        $product=products::with('files')->get();

        if($product){
            return response()->json([
                'status'=>200,
                'message'=>'success',
                'data'=>$product]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'failed',
                'data'=>'not found',
                ], 404 );
        }     
    }
}
