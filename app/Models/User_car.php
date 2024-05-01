<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_car extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car_engine()
    {
        return $this->belongsTo(Car_engine::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }
}
