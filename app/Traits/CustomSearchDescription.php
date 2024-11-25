<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CustomSearchDescription
{

    public function scopeSearchDesc(Builder $query, $value): Builder
    {
        return $query->where(function ($q) use ($value) {
            $q->where('description_ar', 'LIKE', '%' . $value . '%');
            $q->orWhere('description_en', 'LIKE', '%' . $value . '%');
        });
    }
}
