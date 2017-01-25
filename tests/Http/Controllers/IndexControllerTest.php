<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testIndexResponseIsOk()
    {
        $this->call('GET', '/')
             ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testContributionResponseIsOk()
    {
        $this->call('GET', '/contribution')
             ->assertStatus(200);
    }
}
