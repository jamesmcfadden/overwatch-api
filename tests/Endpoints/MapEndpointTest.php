<?php

use App\Models\Map;
use App\Models\Event;
use App\Models\MapStage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MapEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testMapList()
    {
        $maps = factory(Map::class, 2)->create([
            'event_id' => factory(Event::class)->create()->id,
        ]);

        $this->json('GET', '/api/v1/map')
             ->assertJson([
                'total' => $maps->count(),
                'first' => url('/api/v1/map?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/map?page=1'),
                'data' => [
                    [
                        'id' => $maps->first()->id,
                        'name' => $maps->first()->name,
                        'location' => $maps->first()->location,
                        'url' => $maps->first()->url,
                        'event' => $maps->first()->event->jsonSerialize(),
                    ],
                    [
                        'id' => $maps->get(1)->id,
                        'name' => $maps->get(1)->name,
                        'location' => $maps->get(1)->location,
                        'url' => $maps->get(1)->url,
                        'event' => $maps->get(1)->event->jsonSerialize(),
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testMapShow()
    {
        $map = factory(Map::class)->create([
            'event_id' => factory(Event::class)->create()->id,
        ]);
        $map->stages()->saveMany(factory(MapStage::class, 3)->create());

        $this->json('GET', sprintf('/api/v1/map/%s', $map->id))
             ->assertJson([
                'id' => $map->id,
                'name' => $map->name,
                'location' => $map->location,
                'url' => $map->url,
                'mode' => $map->mode->jsonSerialize(),
                'stages' => $map->stages->jsonSerialize(),
                'event' => $map->event->jsonSerialize(),
             ]);
    }
}
