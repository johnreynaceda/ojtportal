<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function studentRequirements()
    {
        return $this->hasMany(StudentRequirement::class);
    }

    public function trainee()
    {
        return $this->hasOne(Trainee::class);
    }

    public function studentJournals()
    {
        return $this->hasMany(StudentJournal::class);
    }
}
