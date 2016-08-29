<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
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
        return $this->attributes['url'] = route('api.event.show', ['id' => $this->attributes['id']]);
    }
}
