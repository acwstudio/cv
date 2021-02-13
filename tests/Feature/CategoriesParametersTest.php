<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryTranslation;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CategoriesParametersTest
 * @package Tests\Feature
 */
class CategoriesParametersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_can_sort_categories_by_name_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $categories = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            return factory(Category::class)->create([
                'alias' => $alias
            ]);
        });

        foreach ($categories as $category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'ru',
            ]));
        }

        $this->get('/api/v1/categories?sort=name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '3',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Anna',
                            'created_at' => $categories[2]->created_at->toJSON(),
                            'updated_at' => $categories[2]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Anna'
                            ]
                        ]
                    ],
                    [
                        "id" => '1',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Bertram',
                            'created_at' => $categories[0]->created_at->toJSON(),
                            'updated_at' => $categories[0]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Bertram'
                            ]
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Claus',
                            'created_at' => $categories[1]->created_at->toJSON(),
                            'updated_at' => $categories[1]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Claus'
                            ]
                        ]
                    ],
                ]
            ]);
    }

    /**
     * @test
     *
     */
    public function it_can_sort_categories_by_name_in_descending_order_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $categories = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            return factory(Category::class)->create([
                'alias' => $alias
            ]);
        });

        foreach ($categories as $category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/categories?sort=-name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '2',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Claus',
                            'created_at' => $categories[1]->created_at->toJSON(),
                            'updated_at' => $categories[1]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Claus'
                            ]
                        ]
                    ],
                    [
                        "id" => '1',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Bertram',
                            'created_at' => $categories[0]->created_at->toJSON(),
                            'updated_at' => $categories[0]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Bertram'
                            ]
                        ]
                    ],
                    [
                        "id" => '3',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Anna',
                            'created_at' => $categories[2]->created_at->toJSON(),
                            'updated_at' => $categories[2]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Anna'
                            ]
                        ]
                    ],
                ]
            ]);
    }

    /**
     * @test
     *
     */
    public function it_can_sort_categories_by_multiple_attributes_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $categories = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            if($alias === 'Bertram'){
                return factory(Category::class)->create([
                    'alias' => $alias,
                    'created_at' => now()->addSeconds(3),
                ]);
            }

            return factory(Category::class)->create([
                'alias' => $alias,
            ]);
        });

        foreach ($categories as $category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/categories?sort=created_at,name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertStatus(200)->assertJson([
            "data" => [
                [
                    "id" => '3',
                    "type" => "categories",
                    "attributes" => [
                        'alias' => 'Anna',
                        'created_at' => $categories[2]->created_at->toJSON(),
                        'updated_at' => $categories[2]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Anna'
                        ]
                    ]
                ],
                [
                    "id" => '2',
                    "type" => "categories",
                    "attributes" => [
                        'alias' => 'Claus',
                        'created_at' => $categories[1]->created_at->toJSON(),
                        'updated_at' => $categories[1]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Claus'
                        ]
                    ]
                ],
                [
                    "id" => '1',
                    "type" => "categories",
                    "attributes" => [
                        'alias' => 'Bertram',
                        'created_at' => $categories[0]->created_at->toJSON(),
                        'updated_at' => $categories[0]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Bertram'
                        ]
                    ]
                ],
            ]
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_sort_categories_by_multiple_attributes_in_descending_order_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $categories = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){

            if($alias === 'Bertram'){
                return factory(Category::class)->create([
                    'alias' => $alias,
                    'created_at' => now()->addSeconds(3),
                ]);
            }

            return factory(Category::class)->create([
                'alias' => $alias,
            ]);
        });

        foreach ($categories as $category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/categories?sort=-created_at,name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '1',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Bertram',
                            'created_at' => $categories[0]->created_at->toJSON(),
                            'updated_at' => $categories[0]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Bertram'
                            ]
                        ]
                    ],
                    [
                        "id" => '3',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Anna',
                            'created_at' => $categories[2]->created_at->toJSON(),
                            'updated_at' => $categories[2]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Anna'
                            ]
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => 'Claus',
                            'created_at' => $categories[1]->created_at->toJSON(),
                            'updated_at' => $categories[1]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Claus'
                            ]
                        ]
                    ],
                ]
            ]);
    }

    /**
     * @test
     *
     */
    public function it_can_paginate_categories_through_a_page_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $categories = factory(Category::class, 10)->create();

        foreach ($categories as $category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/categories?page[size]=5&page[number]=1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '1',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[0]->alias,
                            'created_at' => $categories[0]->created_at->toJSON(),
                            'updated_at' => $categories[0]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[1]->alias,
                            'created_at' => $categories[1]->created_at->toJSON(),
                            'updated_at' => $categories[1]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '3',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[2]->alias,
                            'created_at' => $categories[2]->created_at->toJSON(),
                            'updated_at' => $categories[2]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '4',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[3]->alias,
                            'created_at' => $categories[3]->created_at->toJSON(),
                            'updated_at' => $categories[3]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '5',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[4]->alias,
                            'created_at' => $categories[4]->created_at->toJSON(),
                            'updated_at' => $categories[4]->updated_at->toJSON(),
                        ]
                    ],
                ],
                'links' => [
                    'first' => route('api.categories.index', ['page[size]' => 5, 'page[number]' => 1]),
                    'last' => route('api.categories.index', ['page[size]' => 5, 'page[number]' => 2]),
                    'prev' => null,
                    'next' => route('api.categories.index', ['page[size]' => 5, 'page[number]' => 2]),
                ]
            ]);
    }

    /**
     * @test
     * @watch
     */
    public function it_can_paginate_categories_through_a_page_query_parameter_and_show_different_pages()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $categories = factory(Category::class, 10)->create();

        foreach ($categories as $category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'name' => $category->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/categories?page[size]=5&page[number]=2', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '6',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[5]->alias,
                            'created_at' => $categories[5]->created_at->toJSON(),
                            'updated_at' => $categories[5]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '7',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[6]->alias,
                            'created_at' => $categories[6]->created_at->toJSON(),
                            'updated_at' => $categories[6]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '8',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[7]->alias,
                            'created_at' => $categories[7]->created_at->toJSON(),
                            'updated_at' => $categories[7]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '9',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[8]->alias,
                            'created_at' => $categories[8]->created_at->toJSON(),
                            'updated_at' => $categories[8]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '10',
                        "type" => "categories",
                        "attributes" => [
                            'alias' => $categories[9]->alias,
                            'created_at' => $categories[9]->created_at->toJSON(),
                            'updated_at' => $categories[9]->updated_at->toJSON(),
                        ]
                    ],
                ],
                'links' => [
                    'first' => route('api.categories.index', ['page[size]' => 5, 'page[number]' => 1]),
                    'last' => route('api.categories.index', ['page[size]' => 5, 'page[number]' => 2]),
                    'prev' => route('api.categories.index', ['page[size]' => 5, 'page[number]' => 1]),
                    'next' => null,
                ]
            ]);
    }
}
