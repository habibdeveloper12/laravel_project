<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportBlacklist extends Model
{
    use HasFactory;

    protected $fillable=['user_id', 'seller_id', 'message', 'status'];

}
