<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'partner_id',
        'country',
        'city',
        'street',
        'zip_code',
    ];
    
    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
