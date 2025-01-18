<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    protected $guarded = [];

    public function trainee(){
        return $this->belongsTo(Trainee::class);
    }
}
