<?php

namespace App\Http\Controllers;

use App\Hero;
use App\Ability;
use App\Reward;
use App\Map;
use App\Achievement;

class IndexController extends Controller
{
    public function index()
    {
        return view('index.index', [
            'heroCount' => Hero::count(),
            'abilityCount' => Ability::count(),
            'rewardCount' => Reward::count(),
            'mapCount' => Map::count(),
            'achievementCount' => Achievement::count(),
        ]);
    }

    public function contribution()
    {
        return view('index.contribution');
    }
}
