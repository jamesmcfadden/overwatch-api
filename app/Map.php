<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class Map extends Model implements ListableInterface, ShowableInterface
{
    public $timestamps = false;

    protected $hidden = ['map_mode_id', 'event_id'];

    protected $appends = ['url'];

    public function mode()
    {
        return $this->belongsTo('App\MapMode', 'map_mode_id');
    }

    public function stages()
    {
        return $this->hasMany('App\MapStage');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route(
            'api.show',
            ['resource' => 'map', 'id' => $this->attributes['id']]
        );
    }

    public function scopeList($query)
    {
        return $query->with('event');
    }

    public function scopeShow($query)
    {
        return $query->with('mode', 'stages', 'event');
    }
}
