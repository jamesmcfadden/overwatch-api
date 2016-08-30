<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class Achievement extends Model implements ListableInterface, ShowableInterface
{
    public $timestamps = false;

    protected $hidden = ['hero_id', 'reward_id'];

    protected $appends = ['url'];

    public function hero()
    {
        return $this->belongsTo('App\Hero');
    }

    public function reward()
    {
        return $this->belongsTo('App\Reward');
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route(
            'api.show',
            ['resource' => 'achievement', 'id' => $this->attributes['id']]
        );
    }

    public function scopeList($query)
    {
        return $query->with('hero', 'reward.type', 'reward.quality');
    }

    public function scopeShow($query)
    {
        return $query->with('hero', 'reward.type', 'reward.quality');
    }
}
