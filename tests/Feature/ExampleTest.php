<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ExampleTest
 * @package Tests\Feature
 */
class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     * @test
     *
     */
    public function BasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
