<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreementterm extends Model
{
    public function partnerhsip(){
        return $this->belongsTo(Partnership::class);
    }
}
