<?php

namespace App\Models\CarModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'cost_minute',
        'created_by',
        'updated_by'
    ];
}
