<?php

use App\Brawl;
use App\BrawlType;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrawlTypeEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testBrawlTypeList()
    {
        $brawlTypes = factory(BrawlType::class, 2)->create();

        $this->json('GET', '/api/v1/brawl-type')
             ->seeJsonEquals([
                'total' => $brawlTypes->count(),
                'first' => url('/api/v1/brawl-type?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/brawl-type?page=1'),
                'data' => [
                    [
                        'id' => $brawlTypes->first()->id,
                        'name' => $brawlTypes->first()->name,
                        'url' => $brawlTypes->first()->url,
                    ],
                    [
                        'id' => $brawlTypes->get(1)->id,
                        'name' => $brawlTypes->get(1)->name,
                        'url' => $brawlTypes->get(1)->url,
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testBrawlTypeShow()
    {
        $brawlType = factory(BrawlType::class)->create();
        $brawls = factory(Brawl::class, 2)->create([
            'brawl_type_id' => $brawlType->id,
        ]);

        $this->json('GET', sprintf('/api/v1/brawl-type/%s', $brawlType->id))
             ->seeJsonEquals([
                'id' => $brawlType->id,
                'name' => $brawlType->name,
                'url' => $brawlType->url,
                'brawls' => $brawls->jsonSerialize(),
             ]);
    }
}
