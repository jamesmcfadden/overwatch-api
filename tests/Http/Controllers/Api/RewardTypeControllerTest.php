<?php

use App\RewardType;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RewardTypeControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testRewardTypeList()
    {
        $rewardTypes = factory(RewardType::class, 2)->create();

        $this->json('GET', '/api/v1/reward-type')
             ->seeJsonEquals([
                'total' => $rewardTypes->count(),
                'first' => url('/api/v1/reward-type?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/reward-type?page=1'),
                'data' => [
                    [
                        'id' => $rewardTypes->first()->id,
                        'name' => $rewardTypes->first()->name,
                    ],
                    [
                        'id' => $rewardTypes->get(1)->id,
                        'name' => $rewardTypes->get(1)->name,
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testRewardTypeShow()
    {
        $rewardType = factory(RewardType::class)->create();

        $this->json('GET', sprintf('/api/v1/reward-type/%s', $rewardType->id))
             ->seeJsonEquals([
                'id' => $rewardType->id,
                'name' => $rewardType->name,
             ]);
    }
}
