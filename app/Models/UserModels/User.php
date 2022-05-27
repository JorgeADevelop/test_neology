<?php

namespace App\Models\UserModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'username',
        'user_type_id'
    ];

    protected $hidden = [
        'password'
    ];
}
