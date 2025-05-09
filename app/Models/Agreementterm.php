<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreementterm extends Model
{
    protected $fillable = [
        'partnership_id', 'description', 'term'
    ];
    public function partnership(){
        return $this->belongsTo(Partnership::class);
    }
}
