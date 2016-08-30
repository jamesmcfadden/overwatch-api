<?php

use App\Hero;
use App\Achievement;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AchievementEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testAchievementList()
    {
        $achievements = factory(Achievement::class, 2)->create([
            'hero_id' => factory(Hero::class)->create()->id,
        ]);

        $achievements->load('reward.type', 'reward.quality');

        $this->json('GET', '/api/v1/achievement')
             ->seeJsonEquals([
                'total' => $achievements->count(),
                'first' => url('/api/v1/achievement?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/achievement?page=1'),
                'data' => [
                    [
                        'id' => $achievements->first()->id,
                        'name' => $achievements->first()->name,
                        'description' => $achievements->first()->description,
                        'url' => $achievements->first()->url,
                        'hero' => $achievements->first()->hero->jsonSerialize(),
                        'reward' => $achievements->first()->reward->jsonSerialize(),
                    ],
                    [
                        'id' => $achievements->get(1)->id,
                        'name' => $achievements->get(1)->name,
                        'description' => $achievements->get(1)->description,
                        'url' => $achievements->get(1)->url,
                        'hero' => $achievements->get(1)->hero->jsonSerialize(),
                        'reward' => $achievements->get(1)->reward->jsonSerialize(),
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testAchievementShow()
    {
        $achievement = factory(Achievement::class)->create([
            'hero_id' => factory(Hero::class)->create()->id,
        ]);

        $achievement->load('reward.type', 'reward.quality');

        $this->json('GET', sprintf('/api/v1/achievement/%s', $achievement->id))
             ->seeJsonEquals([
                'id' => $achievement->id,
                'name' => $achievement->name,
                'description' => $achievement->description,
                'url' => $achievement->url,
                'hero' => $achievement->hero->jsonSerialize(),
                'reward' => $achievement->reward->jsonSerialize(),
             ]);
    }
}
