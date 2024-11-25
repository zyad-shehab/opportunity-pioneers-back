<?php

namespace App\Models;

use App\Traits\CustomSearchName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes, HasUuids, CustomSearchName;

    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name_ar', 'name_en'];

    /**
     * Get the users for the country.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
