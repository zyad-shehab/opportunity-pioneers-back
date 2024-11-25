<?php

namespace App\Models;

use App\Traits\HasFiles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasFiles;

    protected $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_id',
        'user_id',
        'cover_letter',
        'status',
        'applied_at',
        'closed_at',
    ];

    /**
     * Get the job that owns the application.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user that owns the application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
