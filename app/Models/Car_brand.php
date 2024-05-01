<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_brand extends Model
{
    use HasFactory;

    public function car_models()
    {
        return $this->hasMany(Car_model::class);
    }
}
