<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'skills',
        'salary_monthly',
        'salary_hourly',
        'endDate',
        'typeOfWork',
        'workTime',
        'description',
    ];

    protected $casts = [
        'skills' => 'json',
    ];
}