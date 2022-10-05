<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportArticle extends Model
{
    use HasFactory;

    protected $fillable =['title', 'slug', 'description','sub_section', 'category', 'added_by', 'like', 'dislike' ];


}
