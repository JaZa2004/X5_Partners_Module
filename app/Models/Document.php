<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function partnership(){
        return $this->belongsTo(Partnership::class);
    }
}
