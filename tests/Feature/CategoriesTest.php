<?php


namespace Tests\Feature;


use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class CategoriesTest
 * @package Tests\Feature
 */
class CategoriesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_returns_a_category_as_resource_object()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $category = factory(Category::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->getJson('/api/v1/categories/1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our assertions */
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => $category->alias,
                        'created_at' => $category->created_at->toJson(),
                        'updated_at' => $category->updated_at->toJson(),
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     */
    public function it_returns_all_categories_as_a_collection_of_resource_objects()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $categories = factory(Category::class, 3)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->getJson('/api/v1/categories', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])

            /** make all of our assertions */
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => '1',
                        'type' => 'categories',
                        'attributes' => [
                            'alias' => $categories[0]->alias,
                            'created_at' => $categories[0]->created_at->toJson(),
                            'updated_at' => $categories[0]->updated_at->toJson(),
                        ]
                    ],
                    [
                        'id' => '2',
                        'type' => 'categories',
                        'attributes' => [
                            'alias' => $categories[1]->alias,
                            'created_at' => $categories[1]->created_at->toJson(),
                            'updated_at' => $categories[1]->updated_at->toJson(),
                        ]
                    ],
                    [
                        'id' => '3',
                        'type' => 'categories',
                        'attributes' => [
                            'alias' => $categories[2]->alias,
                            'created_at' => $categories[2]->created_at->toJson(),
                            'updated_at' => $categories[2]->updated_at->toJson(),
                        ]
                    ],
                ],

            ]);
    }

    /**
     * @test
     */
    public function it_can_create_a_category_from_a_resource_object()
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
                    'alias' => 'Test Alias'
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => 'Test Alias',
                        'created_at' => now()->setMilliseconds(0)->toJSON(),
                        'updated_at' => now()->setMilliseconds(0)->toJSON(),
                    ]
                ]
            ])
            ->assertHeader('Location', url('/api/v1/categories/1'));

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_can_update_a_category_from_a_resource_object()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        $creationTimestamp = now();
        sleep(1);

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'Another Alias'
                ]
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])

            /** make all of our assertions */
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => 'Another Alias',
                        'created_at' => $creationTimestamp->setMilliseconds(0)->toJSON(),
                        'updated_at' => now()->setMilliseconds(0)->toJSON(),
//                        'updated_at' => now()->setSeconds(0)->toJSON()
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => 'Another Alias'
        ]);
    }

    /**
     * @test
     */
    public function it_cah_delete_a_category_through_a_delete_request()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->delete('/api/v1/categories/1', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            /** make all of our assertions */
            ->assertStatus(204);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => $category->alias
        ]);
    }
}
