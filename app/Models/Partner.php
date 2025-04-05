<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'company_name', 'partner_type', 'phone_number','company_logo'
    ];
    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function partnerships(){
        return $this->hasMany(Partnership::class);
    }

    public function representatives(){
        return $this->hasMany(Representative::class);
    }


}
