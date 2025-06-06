<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }

    public function supervisorMoa()
    {
        return $this->hasOne(SupervisorMoa::class);
    }

    public function studentCompanies()
    {
        return $this->hasMany(StudentCompany::class);
    }
}
