<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPreference extends Model
{
    use HasFactory;

    protected $fillable = ['fulltime', 'parttime', 'role'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
