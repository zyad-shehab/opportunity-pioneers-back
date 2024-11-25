<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUuids;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'bio_ar',
        'bio_en',
        'profile_picture',
        'type',
        'status',
        'password',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_code',
        'phone_verified_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should use uuid.
     *
     * @var array<int, string>
     */
    protected $uuids = ['id'];

    /**
     * Get the country that owns the user.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user's applications.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the user's notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the user's jobs.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the user's services.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the user's projects.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the user's donations.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the user's assignment.
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
