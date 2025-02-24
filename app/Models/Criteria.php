<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $guarded = [];

    public function criteriaQuestions(){
        return $this->hasMany(CriteriaQuestion::class);
    }
}
