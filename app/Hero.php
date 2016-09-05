<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use App\Concerns\Model\HasUrlAttributeTrait;

class Hero extends Model implements ListableInterface, ShowableInterface
{
    use HasUrlAttributeTrait;

    public $timestamps = false;

    protected $resource = 'hero';

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

    public function scopeList(Builder $query)
    {
        return $query;
    }

    public function scopeShow(Builder $query)
    {
        return $query->with('role', 'subRoles', 'abilities', 'rewards.type', 'rewards.quality', 'rewards.event');
    }
}
