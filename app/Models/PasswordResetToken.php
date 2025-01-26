<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    // Disable timestamps since  handling the 'created_at'
    public $timestamps = false;

    protected $fillable = [
        'email',
        'type',
        'token',
        'created_at',
    ];

    protected $primaryKey = 'id';

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
