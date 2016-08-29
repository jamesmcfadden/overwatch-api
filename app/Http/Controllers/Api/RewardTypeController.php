<?php

namespace App\Http\Controllers\Api;

use App\RewardType;

class RewardTypeController extends Controller
{
    public function index()
    {
        return RewardType::paginate($this->numberResults);
    }

    public function show(RewardType $rewardType)
    {
        return $rewardType;
    }
}
