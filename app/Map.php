<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use App\Concerns\Model\HasUrlAttributeTrait;

class Map extends Model implements ListableInterface, ShowableInterface
{
    use HasUrlAttributeTrait;

    public $timestamps = false;

    protected $resource = 'map';

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

    public function scopeList(Builder $query)
    {
        return $query->with('event');
    }

    public function scopeShow(Builder $query)
    {
        return $query->with('mode', 'stages', 'event');
    }
}
