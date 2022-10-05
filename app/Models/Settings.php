<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable =['banner','banner_title', 'withdraw_min','withdraw_fee','paypal_sandbox',  'banner_description', 'carousel_title','meta_description', 'meta_keywords', 'logo', 'favicon', 'address', 'email', 'phone', 'about', 'workflow_image', 'workflow_video',
                            'workflow_background', 'facebook_url', 'twitter_url', 'instagram_url', ];

}
