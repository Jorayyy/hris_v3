<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['user_id', 'pay_period', 'base_salary', 'bonus', 'deductions', 'net_pay', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
