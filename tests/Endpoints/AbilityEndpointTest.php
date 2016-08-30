<?php

use App\Ability;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AbilityEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testAbilityList()
    {
        $abilities = factory(Ability::class, 2)->create();

        $this->json('GET', '/api/v1/ability')
             ->seeJsonEquals([
                'total' => $abilities->count(),
                'first' => url('/api/v1/ability?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/ability?page=1'),
                'data' => [
                    [
                        'id' => $abilities->first()->id,
                        'name' => $abilities->first()->name,
                        'description' => $abilities->first()->description,
                        'is_ultimate' => $abilities->first()->is_ultimate,
                        'url' => $abilities->first()->url,
                        'hero' => $abilities->first()->hero->jsonSerialize(),
                    ],
                    [
                        'id' => $abilities->get(1)->id,
                        'name' => $abilities->get(1)->name,
                        'description' => $abilities->get(1)->description,
                        'is_ultimate' => $abilities->get(1)->is_ultimate,
                        'url' => $abilities->get(1)->url,
                        'hero' => $abilities->get(1)->hero->jsonSerialize(),
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testAbilityShow()
    {
        $ability = factory(Ability::class)->create();

        $this->json('GET', sprintf('/api/v1/ability/%s', $ability->id))
             ->seeJsonEquals([
                'id' => $ability->id,
                'name' => $ability->name,
                'description' => $ability->description,
                'is_ultimate' => $ability->is_ultimate,
                'url' => $ability->url,
                'hero' => $ability->hero->jsonSerialize(),
             ]);
    }
}
