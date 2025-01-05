<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPreference extends Model
{
    use HasFactory;

    protected $fillable = ['isfulltime', 'isparttime', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
