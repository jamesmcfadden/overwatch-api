<?php

use App\Models\Platform;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlatformEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testPlatformList()
    {
        $platforms = factory(Platform::class, 2)->create();

        $this->json('GET', '/api/v1/platform')
             ->assertJson([
                'total' => $platforms->count(),
                'first' => url('/api/v1/platform?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/platform?page=1'),
                'data' => [
                    [
                        'id' => $platforms->first()->id,
                        'name' => $platforms->first()->name,
                        'url' => $platforms->first()->url,
                    ],
                    [
                        'id' => $platforms->get(1)->id,
                        'name' => $platforms->get(1)->name,
                        'url' => $platforms->get(1)->url,
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testPlatformShow()
    {
        $platform = factory(Platform::class)->create();

        $this->json('GET', sprintf('/api/v1/platform/%s', $platform->id))
             ->assertJson([
                'id' => $platform->id,
                'name' => $platform->name,
                'url' => $platform->url,
             ]);
    }
}
