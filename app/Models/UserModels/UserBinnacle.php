<?php

namespace App\Models\UserModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBinnacle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];
}
