<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function BasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
