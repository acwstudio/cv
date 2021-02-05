<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class CategoriesStoreValidationTest
 * @package Tests\Feature
 */
class CategoriesStoreValidationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @watch
     */
    public function it_validates_that_the_type_member_is_given_when_creating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => '',
                'attributes' => [
                    'alias' => 'Test Alias'
                ]
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.type field is required.',
                        'source' => [
                            'pointer' => '/data/type',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_type_member_has_the_value_of_categories_when_creating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'category',
                'attributes' => [
                    'alias' => 'Test Alias'
                ]
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The selected data.type is invalid.',
                        'source' => [
                            'pointer' => '/data/type',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_at_tributes_member_has_been_given_when_creating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'categories',
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes field is required.',
                        'source' => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_attributes_member_is_an_object_given_when_creating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'categories',
                'attributes' => 'not an object',
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes must be an array.',
                        'source'  => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_an_alias_attribute_is_given_when_creating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'categories',
                'attributes' => [
                    'alias' => ''
                ],
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.alias field is required.',
                        'source'  => [
                            'pointer' => '/data/attributes/alias',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_an_alias_attribute_is_a_string_when_creating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'categories',
                'attributes' => [
                    'alias' => 47
                ],
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.alias must be a string.',
                        'source'  => [
                            'pointer' => '/data/attributes/alias',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }
}
