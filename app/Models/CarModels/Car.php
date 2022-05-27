<?php

namespace App\Models\CarModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'car_type_id',
        'created_by',
        'updated_by'
    ];
}
