<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function car_model()
    {
        return $this->belongsTo(Car_model::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function modificationDetail()
    {
        return $this->hasMany(ModificationDetail::class);
    }
}
