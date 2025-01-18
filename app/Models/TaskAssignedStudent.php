<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssignedStudent extends Model
{
    protected $guarded = [];

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function trainee(){
        return $this->belongsTo(Trainee::class);
    }
}
