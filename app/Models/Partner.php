<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function partnerships(){
        return $this->hasMany(Partnership::class);
    }


}
