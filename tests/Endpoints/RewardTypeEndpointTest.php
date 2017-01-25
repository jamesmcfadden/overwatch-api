<?php

use App\Models\RewardType;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RewardTypeEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testRewardTypeList()
    {
        $rewardTypes = factory(RewardType::class, 2)->create();

        $this->json('GET', '/api/v1/reward-type')
             ->assertJson([
                'total' => $rewardTypes->count(),
                'first' => url('/api/v1/reward-type?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/reward-type?page=1'),
                'data' => [
                    [
                        'id' => $rewardTypes->first()->id,
                        'name' => $rewardTypes->first()->name,
                        'url' => $rewardTypes->first()->url,
                    ],
                    [
                        'id' => $rewardTypes->get(1)->id,
                        'name' => $rewardTypes->get(1)->name,
                        'url' => $rewardTypes->get(1)->url,
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
             ->assertJson([
                'id' => $rewardType->id,
                'name' => $rewardType->name,
                'url' => $rewardType->url,
             ]);
    }
}
