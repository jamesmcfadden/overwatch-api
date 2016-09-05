<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use App\Concerns\Model\HasUrlAttributeTrait;

class BrawlType extends Model implements ListableInterface, ShowableInterface
{
    use HasUrlAttributeTrait;

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * @var string
     */
    protected $resource = 'brawl-type';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brawls()
    {
        return $this->hasMany(Brawl::class);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList(Builder $query)
    {
        return $query;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow(Builder $query)
    {
        return $query->with('brawls');
    }
}
