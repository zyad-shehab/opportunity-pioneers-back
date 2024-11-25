<?php

namespace App\Models;

use App\Traits\CustomSearchName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, HasUuids, SoftDeletes, CustomSearchName;

    protected $table = 'locations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    /**
     * Get the jobs for the location.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
