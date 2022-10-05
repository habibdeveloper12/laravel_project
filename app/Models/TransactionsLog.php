<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status','type','description', 'tran_id', 'method', 'method_info','amount', 'amount_to_receive'];

}
