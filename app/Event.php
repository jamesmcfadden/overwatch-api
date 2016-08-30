<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class Event extends Model implements ListableInterface, ShowableInterface
{
    public $timestamps = false;

    protected $appends = ['url'];

    public function rewards()
    {
        return $this->hasMany('App\Reward');
    }

    public function maps()
    {
        return $this->hasMany('App\Map');
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route(
            'api.show',
            ['resource' => 'event', 'id' => $this->attributes['id']]
        );
    }

    public function scopeShow($query)
    {
        return $query->with('maps', 'rewards');
    }

    public function scopeList($query)
    {
        return $query;
    }
}
