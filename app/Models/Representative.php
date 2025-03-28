<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_at_company'
    ];    
    
    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
