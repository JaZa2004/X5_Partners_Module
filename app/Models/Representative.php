<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_at_company',
        'partner_id'  // assuming a foreign key exists in the partner table to representatives table
    ];    
    
    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
