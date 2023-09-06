<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'Payments';

    protected $fillable=[
       'id',
       'order_id',
       'amount',
       'status',
       'payment_type'
    ];
}
