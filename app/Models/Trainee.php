<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    protected $guarded = [];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function supervisor(){
        return $this->belongsTo(Supervisor::class);
    }

    public function taskAssignedStudents(){
        return $this->hasMany(TaskAssignedStudent::class);
    }

    public function dailyTimeRecords(){
        return $this->hasMany(DailyTimeRecord::class);
    }

    public function absents(){
        return $this->hasMany(Absent::class);
    }
}
