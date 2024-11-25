<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'donations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supporter_id',
        'campaign_id',
        'amount',
        'currency',
        'notes',
    ];

    /**
     * Get the supporter that owns the donation.
     */
    public function supporter()
    {
        return $this->belongsTo(User::class, 'supporter_id');
    }

    /**
     * Get the campaign that owns the donation.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
