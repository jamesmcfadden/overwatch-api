<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Builder;

interface ShowableInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow(Builder $query);
}
