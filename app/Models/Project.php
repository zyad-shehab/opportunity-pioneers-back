<?php

namespace App\Models;

use App\Traits\CustomSearchDescription;
use App\Traits\CustomSearchTitle;
use App\Traits\HasAssignments;
use App\Traits\HasFiles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        CustomSearchTitle,
        CustomSearchDescription,
        HasFiles,
        HasAssignments;

    protected $table = 'projects';

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
        'budget',
        'status',
        'client_id',
        'required_personnel',
        'closed_at',
    ];

    /**
     * Get the client that owns the project.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
