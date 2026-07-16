<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = [
    'user_id', 
    'date', 
    'clock_in', 
    'break1_out', 
    'break1_in', 
    'lunch_out', 
    'lunch_in', 
    'break2_out', 
    'break2_in', 
    'clock_out'
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
