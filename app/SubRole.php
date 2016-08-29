<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubRole extends Model
{
    public $timestamps = false;

    protected $hidden = ['pivot'];
}
