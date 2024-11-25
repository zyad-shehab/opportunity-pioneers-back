<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CustomSearchName
{
    public function scopeSearchName(Builder $query, $value): Builder
    {
        return $query->where(function ($q) use ($value) {
            $q->where('name_ar', 'LIKE', '%' . $value . '%');
            $q->orWhere('name_en', 'LIKE', '%' . $value . '%');
        });
    }
}