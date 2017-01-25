<?php

use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\ResourceController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiResourceControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListResourceReturnsTheCorrectResource()
    {
        $heroes = factory(Hero::class, 50)->create();

        $response = $this->call('GET', '/api/v1/hero');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id' => $heroes->get(0)->id,
                    'name' => $heroes->get(0)->name,
                    'description' => $heroes->get(0)->description,
                ],
                [
                    'id' => $heroes->get(1)->id,
                    'name' => $heroes->get(1)->name,
                    'description' => $heroes->get(1)->description,
                ],
                [
                    'id' => $heroes->get(2)->id,
                    'name' => $heroes->get(2)->name,
                    'description' => $heroes->get(2)->description,
                ],
            ],
        ]);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * @return void
     */
    public function testShowResourceReturnsTheCorrectResource()
    {
        $heroes = factory(Hero::class, 50)->create();
        $hero = $heroes->get(15);

        $response = $this->call('GET', sprintf('/api/v1/hero/%s', $hero->id));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $hero->id,
            'name' => $hero->name,
            'description' => $hero->description,
        ]);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * @return void
     */
    public function testListInvalidResourceReturnsPageNotFound()
    {
        $this->call('GET', '/api/v1/cake')
             ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testShowInvalidResourceReturnsPageNotFound()
    {
        $this->call('GET', '/api/v1/cake/99')
             ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testNonShowableResourceCannotBeShown()
    {
        $model = Mockery::mock(Model::class);

        $this->setExpectedException(NotFoundHttpException::class);

        $controller = new ResourceController();
        $controller->showResource($model, 1);
    }

    /**
     * @return void
     */
    public function testNonListableResourceCannotBeListed()
    {
        $model = Mockery::mock(Model::class);
        $request = Mockery::mock(Request::class);

        $this->setExpectedException(NotFoundHttpException::class);

        $controller = new ResourceController();
        $controller->listResource($model, $request);
    }

    /**
     * @return void
     */
    public function testResourceListPagination()
    {
        $heroes = factory(Hero::class, 201)->create();

        $response = $this->call('GET', sprintf('/api/v1/hero?limit=%d&page=%d', 20, 2));

        $response->assertStatus(200);
        $response->assertJson([
            'total' => $heroes->count(),
            'first' => url('/api/v1/hero?page=1'),
            'next' => url('/api/v1/hero?page=3'),
            'previous' => url('/api/v1/hero?page=1'),
            'last' => url('/api/v1/hero?page=11'),
        ]);
    }

    /**
     * @return void
     */
    public function testResourceNotFoundReturnsPageNotFound()
    {
        $heroes = factory(Hero::class, 5)->create();

        $this->call('GET', sprintf('/api/v1/hero/%d', 5000))
             ->assertStatus(404);
    }
}
