<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'description',
        'location',
        'found_at',
        'company_size',
        'about',
        'website',
        'linkedin',
    ];
}
