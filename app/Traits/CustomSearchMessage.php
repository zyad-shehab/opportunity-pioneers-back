<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CustomSearchMessage
{

    public function scopeSearchMessage(Builder $query, $value): Builder
    {
        return $query->where(function ($q) use ($value) {
            $q->where('message_ar', 'LIKE', '%' . $value . '%');
            $q->orWhere('message_en', 'LIKE', '%' . $value . '%');
        });
    }
}
