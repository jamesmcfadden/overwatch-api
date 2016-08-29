<?php

namespace App\Http\Controllers\Api;

use App\Ability;

class AbilityController extends Controller
{
    public function index()
    {
        return Ability::with('hero')->paginate($this->numberResults);
    }

    public function show(Ability $ability)
    {
        $ability->load('hero');

        return $ability;
    }
}
