<?php

use App\Hero;
use App\Event;
use App\Reward;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RewardEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testRewardList()
    {
        $rewards = factory(Reward::class, 2)->create();

        $this->json('GET', '/api/v1/reward')
             ->seeJsonEquals([
                'total' => $rewards->count(),
                'first' => url('/api/v1/reward?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/reward?page=1'),
                'data' => [
                    [
                        'id' => $rewards->first()->id,
                        'name' => $rewards->first()->name,
                        'cost' => $rewards->first()->cost,
                        'url' => $rewards->first()->url,
                        'type' => $rewards->first()->type->jsonSerialize(),
                        'quality' => $rewards->first()->quality->jsonSerialize(),
                    ],
                    [
                        'id' => $rewards->get(1)->id,
                        'name' => $rewards->get(1)->name,
                        'cost' => $rewards->get(1)->cost,
                        'url' => $rewards->get(1)->url,
                        'type' => $rewards->get(1)->type->jsonSerialize(),
                        'quality' => $rewards->get(1)->quality->jsonSerialize(),
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testRewardShow()
    {
        $reward = factory(Reward::class)->create([
            'hero_id' => factory(Hero::class)->create()->id,
            'event_id' => factory(Event::class)->create()->id,
        ]);

        $this->json('GET', sprintf('/api/v1/reward/%s', $reward->id))
             ->seeJsonEquals([
                'id' => $reward->id,
                'name' => $reward->name,
                'cost' => $reward->cost,
                'url' => $reward->url,
                'type' => $reward->type,
                'hero' => $reward->hero->jsonSerialize(),
                'quality' => $reward->quality->jsonSerialize(),
                'event' => $reward->event->jsonSerialize(),
             ]);
    }
}
