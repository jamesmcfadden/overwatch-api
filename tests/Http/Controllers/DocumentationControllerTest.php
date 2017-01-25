<?php

class DocumentationControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testDocumentationResponseIsOk()
    {
        $this->call('GET', '/docs/v1')
             ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testInvalidDocumentationVersionReturnsNotFound()
    {
        $this->call('GET', '/docs/v20')
             ->assertStatus(404);
    }
}
