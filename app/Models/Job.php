<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'skills',
        'salary',
        'endDate',
        'typeOfWork',
        'workTime',
        'description',
    ];

    protected $casts = [
        'skills' => 'json',
        'salary' => 'json',
    ];

    public function jobSeekers(): BelongsToMany
    {
        return $this->BelongsToMany(JobSeeker::class, 'job_seeker_jobs')
            ->withPivot('created_at')
            ->withTimestamps();
    }
}



