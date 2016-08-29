<?php

namespace App\Http\Controllers\Api;

use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate($this->numberResults);

        return $events;
    }

    public function show(Event $event)
    {
        $event->load('rewards');

        return $event;
    }
}
