<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificationDetail extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function modification()
    {
        return $this->belongsTo(Modification::class);
    }
}
