<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_engine extends Model
{
    use HasFactory;

    public function car_model()
    {
        return $this->belongsTo(Car_model::class);
    }

    public function user_cars()
    {
        return $this->hasMany(User_car::class);
    }
}
