<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ProofDocument extends Model
{
    public function getTypeAttribute($value)
    {
       return Str::title($value);
    }
}
