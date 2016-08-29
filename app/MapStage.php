<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapStage extends Model
{
    public $timestamps = false;

    protected $hidden = ['map_id'];

    public function map()
    {
        return $this->belongsTo('App\Map');
    }
}
