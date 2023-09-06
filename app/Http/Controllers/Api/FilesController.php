<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::all();

        return response()->json([
            'status'=>200,
            'message'=>'successful',
            'data'=>$files,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'product_id'=>'required',
            'img' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip|max:2048'  
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $file=$request->file('img');
        $fileName = auth()->id() . '_' . time();  
        $folder="products/" . $request['product_id'];
        $path = $file->storeAs($folder,$fileName);

        File::create([
            'user_id' => auth()->id(),
            'product_id'=>$request['product_id'],
            'name' => $fileName,
        ]);

        return response()->json([
            'status'=>200,
            'message'=>'File added successfully.',
            'data'=>$path,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($productid,$filename)
    {
        $filePath='products'.'/'.$productid .'/'.$filename;

        if (Storage::exists($filePath)) {
            $file = Storage::get($filePath);
            $mimeType = Storage::mimeType($filePath);    
            return response($file, 200)->header('Content-Type', $mimeType);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'File not found.',
            ]);
        }
    }
}
