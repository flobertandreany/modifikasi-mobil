<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_model extends Model
{
    use HasFactory;

    public function car_brand()
    {
        return $this->belongsTo(Car_brand::class);
    }

    public function car_engines()
    {
        return $this->hasMany(Car_engine::class);
    }

    public function spareparts()
    {
        return $this->hasMany(Spareparts::class);
    }

    public function modifications()
    {
        return $this->hasMany(Modification::class);
    }
}
