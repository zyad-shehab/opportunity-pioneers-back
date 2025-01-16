<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPreference extends Model
{
    use HasFactory;

    protected $fillable = ['is_fulltime', 'is_parttime', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
