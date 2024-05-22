<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spareparts extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function car_model()
    {
        return $this->belongsTo(Car_model::class);
    }

    public function sparepartDetail()
    {
        return $this->hasMany(SparepartDetail::class);
    }
}
