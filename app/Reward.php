<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use App\Concerns\Model\HasUrlAttributeTrait;

class Reward extends Model implements ListableInterface, ShowableInterface
{
    use HasUrlAttributeTrait;

    public $timestamps = false;

    protected $resource = 'reward';

    protected $hidden = [
        'currency',
        'hero_id',
        'reward_type_id',
        'currency_id',
        'quality_id',
        'event_id',
    ];

    protected $appends = ['cost', 'url'];

    public function type()
    {
        return $this->belongsTo('App\RewardType', 'reward_type_id');
    }

    public function hero()
    {
        return $this->belongsTo('App\Hero');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function quality()
    {
        return $this->belongsTo('App\Quality');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function getCostAttribute()
    {
        if ($this->currency) {
            return new Cost($this->currency, $this->attributes['cost']);
        }
    }

    public function scopeList(Builder $query)
    {
        return $query->with('type', 'currency', 'quality');
    }

    public function scopeShow(Builder $query)
    {
        return $query->with('type', 'hero', 'currency', 'quality', 'event');
    }
}
