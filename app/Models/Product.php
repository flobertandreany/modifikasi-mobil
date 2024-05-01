<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function Spareparts()
    {
        return $this->hasMany(Spareparts::class);
    }

    public function Modification()
    {
        return $this->hasMany(Modification::class);
    }
}
