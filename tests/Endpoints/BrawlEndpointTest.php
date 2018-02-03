<?php

use App\Models\Brawl;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrawlEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testBrawlList()
    {
        $brawls = factory(Brawl::class, 2)->create();

        $this->json('GET', '/api/v1/brawl')
             ->assertJson([
                'total' => $brawls->count(),
                'first' => url('/api/v1/brawl?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/brawl?page=1'),
                'data' => [
                    [
                        'id' => $brawls->first()->id,
                        'start_date' => $brawls->first()->start_date,
                        'url' => $brawls->first()->url,
                        'brawl_type' => $brawls->first()->brawlType->jsonSerialize(),
                    ],
                    [
                        'id' => $brawls->get(1)->id,
                        'start_date' => $brawls->get(1)->start_date,
                        'url' => $brawls->get(1)->url,
                        'brawl_type' => $brawls->get(1)->brawlType->jsonSerialize(),
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testBrawlShow()
    {
        $brawl = factory(Brawl::class)->create();

        $this->json('GET', sprintf('/api/v1/brawl/%s', $brawl->id))
             ->assertJson([
                'id' => $brawl->id,
                'start_date' => $brawl->start_date,
                'url' => $brawl->url,
                'brawl_type' => $brawl->brawlType->jsonSerialize(),
             ]);
    }
}
