<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $fillable = [
        'partner_id', 'status', 'start_date', 'end_date'
    ];
    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function partner(){
        return $this->belongsTo(Partner::class);
    }

    public function agreementterms(){
        return $this->hasMany(Agreementterm::class);
    }
    public function services(){
        return $this->hasMany(Service::class);
    }
}
