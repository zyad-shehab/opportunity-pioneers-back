<?php

namespace App\Models;

use App\Traits\HasAssignments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'assignments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the assignment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assignable model that owns the assignment.
     */
    public function assignable()
    {
        return $this->morphTo();
    }
}
