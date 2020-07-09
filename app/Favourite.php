<?php

namespace App;

use App\CurrencyCode;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    public function base()
    {
        return $this->belongsTo(CurrencyCode::class, 'currency_code_id_1');
    }

    public function to()
    {
        return $this->belongsTo(CurrencyCode::class, 'currency_code_id_2');
    }
}
