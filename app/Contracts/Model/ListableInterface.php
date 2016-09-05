<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Builder;

interface ListableInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList(Builder $query);
}
