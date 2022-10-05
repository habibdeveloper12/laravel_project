<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends \Illuminate\Foundation\Auth\User
{
    use HasFactory, Notifiable;

    protected $guard = 'admins';
    protected $fillable = ['username', 'email', 'password', 'status'];

}
