<?php


namespace Tests\Feature;

use App\Category;
use App\CategoryTranslation;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class CategoriesRelationshipsTest
 * @package Tests\Feature
 */
class CategoriesRelationshipsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_returns_category_relationship_to_translations_adhering_to_json_api_spec()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        factory(Category::class)->create()->each(function ($category) {
            /** @var $category Category*/
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en'
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru'
            ]));
        });
        $category = Category::find(1);

        Passport::actingAs($user);

        $this->getJson('/api/v1/categories/1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'relationships' => [
                        'translations' => [
                            'links' => [
                                'self' => route('categories.relationships.translations',
                                    ['id' => $category->id]),
                                'related' => route('categories.translations',
                                    ['id' => $category->id])
                            ],
                            'data' => [
                                [
                                    'id' => (string)$category->translations[0]->id,
                                    'type' => 'category_translations'
                                ],
                                [
                                    'id' => (string)$category->translations[1]->id,
                                    'type' => 'category_translations'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /**
     *
     */
    public function a_relationship_link_to_translations_returns_all_related_translations_as_resource_id_objects()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        factory(Category::class, 3)->create()->each(function ($category) {
            /** @var $category Category*/
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en'
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru'
            ]));
        });

        $categories = Category::all();

        Passport::actingAs($user);

        /** run the code to be tested */
        $this->getJson('/api/v1/categories/1/relationships/translations', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => '1',
                        'type' => 'category_translations',
                    ],
                    [
                        'id' => '2',
                        'type' => 'category_translations',
                    ],
                ]
            ]);
    }

    /**
     *
     */
    public function it_includes_related_resource_objects_for_translations_when_an_include_query_param_to_translations_is_given()
    {
        /** set up our world */
        \Lang::setLocale('en');

        $user = factory(User::class)->create();
        factory(Category::class)->create()->each(function ($category) {
            /** @var $category Category*/
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
            ]));
        });
        $category = Category::find(1);
//        dump($category->translations->get(0)->category_id);
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->getJson('/api/v1/categories/1?include=translations', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'relationships' => [
                        'translations' => [
                            'links' => [
                                'self' => route(
                                    'categories.relationships.translations',
                                    ['id' => $category->id]
                                ),
                                'related' => route(
                                    'categories.translations',
                                    ['id' => $category->id]
                                )
                            ],
                            'data' => [
                                [
                                    'id' => $category->translations->get(0)->id,
                                    'type' => 'category_translations'
                                ],
                                [
                                    'id' => $category->translations->get(1)->id,
                                    'type' => 'category_translations'
                                ]
                            ]
                        ]
                    ]
                ],
                'included' => [
                    [
                        'id' => '1',
                        'type' => 'category_translations',
                        'attributes' => [
                            'category_id' => $category->translations->get(0)->category_id,
                            'locale' => $category->translations->get(0)->locale,
                            'name' => $category->translations->get(0)->name,
//                            'created_at' => $category->translations->get(0)->created_at->toJson(),
//                            'updated_at' => $category->translations->get(0)->updated_at->toJson(),
                        ]
                    ],
                    [
                        'id' => '2',
                        'type' => 'category_translations',
                        'attributes' => [
                            'category_id' => $category->translations->get(1)->category_id,
                            'locale' => $category->translations->get(1)->locale,
                            'name' => $category->translations->get(1)->name,
//                            'created_at' => $category->translations->get(1)->created_at->toJson(),
//                            'updated_at' => $category->translations->get(1)->updated_at->toJson(),
                        ]
                    ]
                ]
            ]);
    }

    /**
     *
     *
     */
    public function it_does_not_include_related_resource_objects_when_an_include_query_param_is_not_given()
    {
        /** set up our world */
        \Lang::setLocale('en');

//        $this->withoutExceptionHandling();
        $category = factory(Category::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->getJson('/api/v1/categories/1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJsonMissing([
                'included' => [],
            ]);
    }

    /**
     *
     */
    public function it_includes_related_resource_objects_for_a_collection_when_an_include_query_param_is_given()
    {
        /** set up our world */
        \Lang::setLocale('en');

        factory(Category::class, 3)->create()->each(function ($category) {
            /** @var $category Category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $categories = Category::all();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->get('/api/v1/categories?include=translations',[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertStatus(200)->assertJson([
            'data' => [
                [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => $categories[0]->alias,
                        'created_at' => $categories[0]->created_at->toJSON(),
                        'updated_at' => $categories[0]->updated_at->toJSON(),
                    ],
                    'relationships' => [
                        'translations' => [
                            'links' => [
                                'self' => route(
                                    'categories.relationships.translations',
                                    ['id' => $categories[0]->id]
                                ),
                                'related' => route(
                                    'categories.translations',
                                    ['id' => $categories[0]->id]
                                )
                            ],
                            'data' => [
                                [
                                    'id' => '1',
                                    'type' => 'category_translations'
                                ],
                                [
                                    'id' => '2',
                                    'type' => 'category_translations'
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'id' => '2',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => $categories[1]->alias,
                        'created_at' => $categories[1]->created_at->toJSON(),
                        'updated_at' => $categories[1]->updated_at->toJSON(),
                    ],
                    'relationships' => [
                        'translations' => [
                            'links' => [
                                'self' => route(
                                    'categories.relationships.translations',
                                    ['id' => $categories[1]->id]
                                ),
                                'related' => route(
                                    'categories.translations',
                                    ['id' => $categories[1]->id]
                                )
                            ],
                            'data' => [
                                [
                                    'id' => '3',
                                    'type' => 'category_translations'
                                ],
                                [
                                    'id' => '4',
                                    'type' => 'category_translations'
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'id' => '3',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => $categories[2]->alias,
                        'created_at' => $categories[2]->created_at->toJSON(),
                        'updated_at' => $categories[2]->updated_at->toJSON(),
                    ],
                    'relationships' => [
                        'translations' => [
                            'links' => [
                                'self' => route(
                                    'categories.relationships.translations',
                                    ['id' => $categories[2]->id]
                                ),
                                'related' => route(
                                    'categories.translations',
                                    ['id' => $categories[2]->id]
                                )
                            ],
                            'data' => [
                                [
                                    'id' => '5',
                                    'type' => 'category_translations'
                                ],
                                [
                                    'id' => '6',
                                    'type' => 'category_translations'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'included' => [
                [
                    'id' => '1',
                    'type' => 'category_translations',
                    'attributes' => [
                        'category_id' => $categories[0]->translations->get(0)->category_id,
                        'locale' => $categories[0]->translations->get(0)->locale,
                        'name' => $categories[0]->translations->get(0)->name,
                    ]
                ],
                [
                    'id' => '2',
                    'type' => 'category_translations',
                    'attributes' => [
                        'category_id' => $categories[0]->translations->get(1)->category_id,
                        'locale' => $categories[0]->translations->get(1)->locale,
                        'name' => $categories[0]->translations->get(1)->name,
                    ]
                ],
                [
                    'id' => '3',
                    'type' => 'category_translations',
                    'attributes' => [
                        'category_id' => $categories[1]->translations->get(0)->category_id,
                        'locale' => $categories[1]->translations->get(0)->locale,
                        'name' => $categories[1]->translations->get(0)->name,
                    ]
                ],
                [
                    'id' => '4',
                    'type' => 'category_translations',
                    'attributes' => [
                        'category_id' => $categories[1]->translations->get(1)->category_id,
                        'locale' => $categories[1]->translations->get(1)->locale,
                        'name' => $categories[1]->translations->get(1)->name,
                    ]
                ],
                [
                    'id' => '5',
                    'type' => 'category_translations',
                    'attributes' => [
                        'category_id' => $categories[2]->translations->get(0)->category_id,
                        'locale' => $categories[2]->translations->get(0)->locale,
                        'name' => $categories[2]->translations->get(0)->name,
                    ]
                ],
                [
                    'id' => '6',
                    'type' => 'category_translations',
                    'attributes' => [
                        'category_id' => $categories[2]->translations->get(1)->category_id,
                        'locale' => $categories[2]->translations->get(1)->locale,
                        'name' => $categories[2]->translations->get(1)->name,
                    ]
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_does_not_include_related_resource_objects_for_a_collection_when_an_include_query_param_is_not_given()
    {
        /** set up our world */
        \Lang::setLocale('en');

        factory(Category::class, 3)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->get('/api/v1/categories', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertStatus(200)
            ->assertJsonMissing([
                'included' => [],
            ]);
    }
}
