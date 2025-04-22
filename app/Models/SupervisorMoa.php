<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupervisorMoa extends Model
{
    protected $guarded = [];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
