<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title', 'description', 'file_path','uploaded_by','partnership_id'
    ];
    public function partnership(){
        return $this->belongsTo(Partnership::class);
    }
}
