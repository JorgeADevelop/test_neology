<?php

namespace App\Models\UserModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lastname',
        'username',
        'user_type_id',
    ];

    protected $hidden = [
        'password'
    ];

    public function UserType() {
        return $this->belongsTo(UserType::class);
    }
}
