<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class RewardType extends Model implements ListableInterface, ShowableInterface
{
    public $timestamps = false;

    public function getUrlAttribute()
    {
        return $this->attributes['url'] = route(
            'api.show',
            ['resource' => 'reward-type', 'id' => $this->attributes['id']]
        );
    }

    public function scopeList($query)
    {
        return $query;
    }

    public function scopeShow($query)
    {
        return $query;
    }
}
