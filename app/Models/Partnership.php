<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function partner_representitive(){
        return $this->hasOne(Partner_representative::class);
    }

    public function partner(){
        return $this->belongsTo(Partner::class);
    }

    public function agreementterms(){
        return $this->hasMany(Agreementterm::class);
    }
}
