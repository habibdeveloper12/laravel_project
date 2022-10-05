<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'method','username', 'tran_id', 'amount', 'email', 'status', 'condition','method_info', 'amount_to_receive'];

}
