<?php

namespace App\Models;

use App\Models\User;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable=[
        "name",
        "price",
        "availability",
        "stock",
        "user_id",
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function orders(){
        return $this->hasMany(Orders::class,'product_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'product_id');
    }
}
