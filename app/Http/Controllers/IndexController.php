<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\Hero;
use App\Models\Reward;
use App\Models\Ability;
use App\Models\Achievement;

class IndexController extends Controller
{
    /**
     * The homepage.
     *
     * @return Illuminate\Http\Response
     */
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

    /**
     * @return Illuminate\Http\Response
     */
    public function contribution()
    {
        return view('index.contribution');
    }
}
