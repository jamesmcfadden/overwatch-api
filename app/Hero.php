<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    public $timestamps = false;

    protected $hidden = ['role_id'];

    protected $appends = ['url'];

    protected $casts = [
        'health' => 'int',
        'armour' => 'int',
        'shield' => 'int',
        'age' => 'int',
        'height' => 'int',
        'difficulty' => 'int',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function subRoles()
    {
        return $this->belongsToMany('App\SubRole', 'hero_sub_roles');
    }

    public function abilities()
    {
        return $this->hasMany('App\Ability');
    }

    public function rewards()
    {
        return $this->hasMany('App\Reward');
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route('api.hero.show', ['id' => $this->attributes['id']]);
    }
}
