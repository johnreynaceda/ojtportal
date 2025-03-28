<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoordinatorRating extends Model
{
    protected $guarded = [];

    protected $casts = [
        'responses' => 'array', // Automatically cast JSON to array
    ];
}
