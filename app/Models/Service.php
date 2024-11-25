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

class Service extends Model
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        CustomSearchTitle,
        CustomSearchDescription,
        HasFiles,
        HasAssignments;

    protected $table = 'services';

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
        'price_per_hour',
        'status',
        'service_provider_id',
        'closed_at',
    ];

    /**
     * Get the service provider that owns the service.
     */
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
