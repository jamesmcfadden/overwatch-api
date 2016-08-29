<?php

namespace App\Http\Controllers\Api;

use App\Hero;

class HeroController extends Controller
{
    public function index()
    {
        return Hero::paginate($this->numberResults);
    }

    public function show(Hero $hero)
    {
        $hero->load('role', 'subRoles', 'abilities', 'rewards.type', 'rewards.quality', 'rewards.event');

        return $hero;
    }
}
