<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
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
        return $this->attributes['url'] = route('api.map.show', ['id' => $this->attributes['id']]);
    }
}
