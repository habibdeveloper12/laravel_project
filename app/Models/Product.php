<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =['title','slug','summary','description','brand_id','stock','price','offer_price', 'discount', 'game', 'status','photo','user_id','cat_id', 'added_by', 'server', 'delivery'];

    public function rel_prods(){
        return $this->hasMany('App\Models\Product', 'cat_id','cat_id')->where('status','active')->limit(5);
    }

}
