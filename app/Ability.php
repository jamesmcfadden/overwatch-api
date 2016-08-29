<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    public $timestamps = false;

    protected $hidden = ['hero_id'];

    protected $appends = ['url'];

    public function hero()
    {
        return $this->belongsTo('App\Hero');
    }

    public function getIsUltimateAttribute($isUltimate)
    {
        return (bool) $isUltimate;
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route('api.ability.show', ['id' => $this->attributes['id']]);
    }
}
