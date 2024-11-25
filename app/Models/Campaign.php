<?php

namespace App\Models;

use App\Traits\CustomSearchDescription;
use App\Traits\CustomSearchName;
use App\Traits\HasFiles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, HasUuids, SoftDeletes, CustomSearchName, CustomSearchDescription, HasFiles;

    protected $table = 'campaigns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'goal_amount',
        'raised_amount',
        'status',
        'start_at',
        'end_at',
    ];

    /**
     * Get the donations for the campaign.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
