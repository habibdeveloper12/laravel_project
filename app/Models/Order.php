<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'is_seen_seller', 'is_seen_admin','is_seen_buyer','order_number', 'product_id', 'total_after_rate', 'total', 'quantity', 'seller','product_price','product',
        'condition','product_id',  'username', 'email', 'payment_method', 'payment_status', 'phone', 'payment_details' ];

}
