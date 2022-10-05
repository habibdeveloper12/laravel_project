<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    use HasFactory;

    protected $fillable = ['buyer_id','rate', 'review', 'status', 'seller_id', 'reviewed', 'order_id', 'reviewer'];
}
