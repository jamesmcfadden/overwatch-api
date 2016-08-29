<?php

use App\Hero;
use App\Role;
use App\Ability;
use App\SubRole;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HeroControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testHeroList()
    {
        $heroes = factory(Hero::class, 2)->create();

        $this->json('GET', '/api/v1/hero')
             ->seeJsonEquals([
                'total' => $heroes->count(),
                'first' => url('/api/v1/hero?page=1'),
                'next' => null,
                'previous' => null,
                'last' => url('/api/v1/hero?page=1'),
                'data' => [
                    [
                        'id' => $heroes->first()->id,
                        'name' => $heroes->first()->name,
                        'description' => $heroes->first()->description,
                        'health' => $heroes->first()->health,
                        'armour' => $heroes->first()->armour,
                        'shield' => $heroes->first()->shield,
                        'real_name' => $heroes->first()->real_name,
                        'age' => $heroes->first()->age,
                        'height' => $heroes->first()->height,
                        'affiliation' => $heroes->first()->affiliation,
                        'base_of_operations' => $heroes->first()->base_of_operations,
                        'difficulty' => $heroes->first()->difficulty,
                        'url' => $heroes->first()->url,
                    ],
                    [
                        'id' => $heroes->get(1)->id,
                        'name' => $heroes->get(1)->name,
                        'description' => $heroes->get(1)->description,
                        'health' => $heroes->get(1)->health,
                        'armour' => $heroes->get(1)->armour,
                        'shield' => $heroes->get(1)->shield,
                        'real_name' => $heroes->get(1)->real_name,
                        'age' => $heroes->get(1)->age,
                        'height' => $heroes->get(1)->height,
                        'affiliation' => $heroes->get(1)->affiliation,
                        'base_of_operations' => $heroes->get(1)->base_of_operations,
                        'difficulty' => $heroes->get(1)->difficulty,
                        'url' => $heroes->get(1)->url,
                    ],
                ],
             ]);
    }

    /**
     * @return void
     */
    public function testHeroShow()
    {
        $hero = factory(Hero::class)->create([
            'role_id' => factory(Role::class)->create()->id,
        ]);
        $hero->subRoles()->saveMany(factory(SubRole::class, 2)->make());

        factory(Ability::class, 10)->create([
            'hero_id' => $hero->id,
        ]);

        $hero->load('role', 'subRoles', 'abilities', 'rewards.type', 'rewards.quality', 'rewards.event');

        $this->json('GET', sprintf('/api/v1/hero/%s', $hero->id))
             ->seeJsonEquals([
                'id' => $hero->id,
                'name' => $hero->name,
                'description' => $hero->description,
                'health' => $hero->health,
                'armour' => $hero->armour,
                'shield' => $hero->shield,
                'real_name' => $hero->real_name,
                'age' => $hero->age,
                'height' => $hero->height,
                'affiliation' => $hero->affiliation,
                'base_of_operations' => $hero->base_of_operations,
                'difficulty' => $hero->difficulty,
                'url' => $hero->url,
                'role' => $hero->role->jsonSerialize(),
                'sub_roles' => $hero->subRoles->jsonSerialize(),
                'abilities' => $hero->abilities->jsonSerialize(),
                'rewards' => $hero->rewards->jsonSerialize(),
             ]);
    }
}
