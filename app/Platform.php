<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class Platform extends Model implements ListableInterface, ShowableInterface
{
    public $timestamps = false;

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route(
            'api.show',
            ['resource' => 'platform', 'id' => $this->attributes['id']]
        );
    }

    public function scopeList(Builder $query)
    {
        return $query;
    }

    public function scopeShow(Builder $query)
    {
        return $query;
    }
}
