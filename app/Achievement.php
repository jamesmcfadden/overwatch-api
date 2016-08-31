<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use App\Concerns\Model\HasUrlAttributeTrait;

class Achievement extends Model implements ListableInterface, ShowableInterface
{
    use HasUrlAttributeTrait;

    public $timestamps = false;

    protected $resource = 'achievement';

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

    public function scopeList($query)
    {
        return $query->with('hero', 'reward.type', 'reward.quality');
    }

    public function scopeShow($query)
    {
        return $query->with('hero', 'reward.type', 'reward.quality');
    }
}
