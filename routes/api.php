<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\authController;
use App\Http\Controllers\Api\cartController;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\FilesController;
use App\Http\Controllers\Api\orderController;
use App\Http\Controllers\Api\paymentController;
use App\Http\Controllers\Api\productController;
use App\Http\Controllers\Api\customerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//register
Route::post('admin',[userController::class,'storeAdmin']);
Route::post('customers',[userController::class, 'storeCustomer']);

//auth
Route::post('login', [authController::class,'Login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

//user
Route::get('user',[userController::class,'index']);
Route::get('user/{id}',[userController::class, 'show']);

//product
Route::middleware('auth:sanctum')->get('products',[productController::class, 'index']);
Route::middleware('auth:sanctum')->get('products/{id}',[productController::class, 'show']);

//cart
Route::middleware('auth:sanctum')->post('cart/{product_id}',[cartController::class, 'addToCart']);
Route::middleware('auth:sanctum')->put('cart/{item_id}',[cartController::class, 'updateCart']);
Route::middleware('auth:sanctum')->delete('cart/{item_id}',[cartController::class, 'removeFromCart']); //remove item from cart
Route::middleware('auth:sanctum')->get('cart/{item_id}',[cartController::class, 'getCartContents']); //show one item from cart
Route::middleware('auth:sanctum')->get('cart',[cartController::class, 'index']);


//orders
Route::middleware('auth:sanctum')->post('order/{product_id}',[orderController::class, 'store']);
Route::middleware('auth:sanctum')->get('admin/order',[orderController::class, 'index']); //admin only
Route::middleware('auth:sanctum')->get('order',[orderController::class, 'showAllOrdersByUserId']);
Route::middleware('auth:sanctum')->get('order/{order_id}',[orderController::class, 'show']);
Route::middleware('auth:sanctum')->put('order/{order_id}',[orderController::class, 'update']);

//payments
Route::middleware('auth:sanctum')->post('payment',[paymentController::class, 'store']);
Route::middleware('auth:sanctum')->get('payment/{id}',[paymentController::class, 'show']);


//File Upload Routes
Route::middleware('auth:sanctum')->get('files',[FilesController::class, 'index']);
Route::middleware('auth:sanctum')->post('files/add',[FilesController::class, 'store']);
Route::middleware('auth:sanctum')->get('files/{productid}/{filename}',[FilesController::class, 'show']);


// admin-only routes 
Route::group(['middleware' => 'admin'], function () {
    Route::middleware('auth:sanctum')->post('product',[productController::class, 'store']);
    Route::middleware('auth:sanctum')->delete('product/{id}',[productController::class, 'remove']);
    Route::middleware('auth:sanctum')->put('product/{id}',[productController::class, 'update']);
    
});

