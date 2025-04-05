<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable=[
        'name', 'description', 'partnership_id','price','cost_type','discount_percentage'
    ];
    public function partnership(){
        return $this->belongsTo(Partnership::class);
    }
}
