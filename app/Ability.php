<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use App\Concerns\Model\HasUrlAttributeTrait;

class Ability extends Model implements ListableInterface, ShowableInterface
{
    use HasUrlAttributeTrait;

    public $timestamps = false;

    protected $resource = 'ability';

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

    public function scopeList($query)
    {
        return $query->with('hero');
    }

    public function scopeShow($query)
    {
        return $query->with('hero');
    }
}
