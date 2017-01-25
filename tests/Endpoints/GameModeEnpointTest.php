<?php

use App\Models\GameMode;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameModeEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testGameModeList()
    {
        $gameModes = factory(GameMode::class, 2)->create();

        $this->json('GET', '/api/v1/game-mode')
             ->assertJson([
                'total' => $gameModes->count(),
                'first' => url('/api/v1/game-mode?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/game-mode?page=1'),
                'data' => [
                    [
                        'id' => $gameModes->first()->id,
                        'name' => $gameModes->first()->name,
                        'url' => $gameModes->first()->url,
                    ],
                    [
                        'id' => $gameModes->get(1)->id,
                        'name' => $gameModes->get(1)->name,
                        'url' => $gameModes->get(1)->url,
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testGameModeShow()
    {
        $gameMode = factory(GameMode::class)->create();

        $this->json('GET', sprintf('/api/v1/game-mode/%s', $gameMode->id))
             ->assertJson([
                'id' => $gameMode->id,
                'name' => $gameMode->name,
                'url' => $gameMode->url,
             ]);
    }
}
