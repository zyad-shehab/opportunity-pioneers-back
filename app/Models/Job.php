<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'skills',
        'salary_monthly',
        'salary_hourly',
        'end_date',
        'type_of_work',
        'work_time',
        'description',
    ];
}
