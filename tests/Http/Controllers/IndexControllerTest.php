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
        $response = $this->call('GET', '/');

        $this->assertResponseOk();
    }

    public function testContributionResponseIsOk()
    {
        $response = $this->call('GET', '/contribution');

        $this->assertResponseOk();
    }
}
