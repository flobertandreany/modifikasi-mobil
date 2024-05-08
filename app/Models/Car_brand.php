<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_brand_name',
        'car_brand_logo',
    ];

    public function car_models()
    {
        return $this->hasMany(Car_model::class);
    }
}
