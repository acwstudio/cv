<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CategoriesUpdateValidationTest
 * @package Tests\Feature
 */
class CategoriesUpdateValidationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_validates_that_an_id_member_is_given_when_updating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'Test Alias',
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.id field is required.',
                        'source'  => [
                            'pointer' => '/data/id',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_an_id_member_is_a_string_when_updating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => 1,
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'Test Alias',
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.id must be a string.',
                        'source'  => [
                            'pointer' => '/data/id',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_type_member_is_given_when_updating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => '',
                'attributes' => [
                    'alias' => 'Test Alias',
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.type field is required.',
                        'source'  => [
                            'pointer' => '/data/type',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_type_member_has_the_value_of_categories_when_updating_an_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'category',
                'attributes' => [
                    'alias' => 'Test Alias',
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The selected data.type is invalid.',
                        'source'  => [
                            'pointer' => '/data/type',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_attributes_member_has_been_given_when_updating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes field is required.',
                        'source'  => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_the_attributes_member_is_an_object_given_when_updating_a_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => 'not an object'
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
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

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_a_alias_attribute_is_a_string_when_updating_an_category()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'alias' => 47
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
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

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'alias' => $category->alias,
        ]);
    }
}
