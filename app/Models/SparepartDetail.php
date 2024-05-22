<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartDetail extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function sparepart()
    {
        return $this->belongsTo(Spareparts::class);
    }
}
