<?php

namespace App\Models;

use App\Models\Payments;
use App\Models\products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'Orders';

    protected $fillable=[
        "discount",
        "total",
        "delivery_status",
        "user_id",
        "product_id",
        // "payment_id",
        "payment_type",
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function product(){
        return $this->belongsTo(products::class,'product_id');
    }
    // public function payment(){
    //     return $this->belongsTo(Payments::class,'payment_id');
    // }
}
