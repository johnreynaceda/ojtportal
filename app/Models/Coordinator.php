<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisorMoas()
    {
        return $this->hasMany(SupervisorMoa::class);
    }
}
