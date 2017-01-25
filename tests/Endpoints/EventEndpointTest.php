<?php

use App\Models\Map;
use App\Models\Event;
use App\Models\Reward;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testEventList()
    {
        $events = factory(Event::class, 2)->create();

        $this->json('GET', '/api/v1/event')
             ->assertJson([
                'total' => $events->count(),
                'first' => url('/api/v1/event?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/event?page=1'),
                'data' => [
                    [
                        'id' => $events->first()->id,
                        'name' => $events->first()->name,
                        'start_date' => $events->first()->start_date,
                        'end_date' => $events->first()->end_date,
                        'url' => $events->first()->url,
                    ],
                    [
                        'id' => $events->get(1)->id,
                        'name' => $events->get(1)->name,
                        'start_date' => $events->get(1)->start_date,
                        'end_date' => $events->get(1)->end_date,
                        'url' => $events->get(1)->url,
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testEventShow()
    {
        $event = factory(Event::class)->create();
        $rewards = factory(Reward::class, 20)->create([
            'event_id' => $event->id,
        ]);
        factory(Map::class)->create(['event_id' => $event->id]);

        $this->json('GET', sprintf('/api/v1/event/%s', $event->id))
             ->assertJson([
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'url' => $event->url,
                'maps' => $event->maps->jsonSerialize(),
                'rewards' => $rewards->jsonSerialize(),
             ]);
    }
}
