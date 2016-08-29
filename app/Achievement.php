<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
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
        return $this->attributes['url'] = route('api.achievement.show', ['id' => $this->attributes['id']]);
    }
}
