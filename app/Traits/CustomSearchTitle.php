<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CustomSearchTitle
{

    public function scopeSearchTitle(Builder $query, $value): Builder
    {
        return $query->where(function ($q) use ($value) {
            $q->where('title_ar', 'LIKE', '%' . $value . '%');
            $q->orWhere('title_en', 'LIKE', '%' . $value . '%');
        });
    }
}