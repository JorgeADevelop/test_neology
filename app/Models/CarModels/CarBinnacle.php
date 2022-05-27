<?php

namespace App\Models\CarModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBinnacle extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'delivery_time',
        'deliver_by_user_id',
        'departure_time',
        'departure_by_user_id',
        'amount'
    ];

    public function Car() {
        return $this->belongsTo(Car::class);
    }
}
