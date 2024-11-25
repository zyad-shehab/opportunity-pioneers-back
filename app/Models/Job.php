<?php

namespace App\Models;

use App\Traits\CustomSearchDescription;
use App\Traits\CustomSearchTitle;
use App\Traits\HasFiles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, HasUuids, SoftDeletes, CustomSearchTitle, CustomSearchDescription, HasFiles;

    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'job_type',
        'salary',
        'location_id',
        'company_id',
        'status',
        'deadline',
        'posted_at',
        'closed_at',
    ];

    /**
     * Get the location that owns the job.
     */

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the company that owns the job.
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    /**
     * Get the applications for the job.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
