<?php


namespace Tests\Feature;


use App\Category;
use App\CategoryTranslation;
use App\User;
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
     *
     *
     */
    public function test_case()
    {
        $this->withoutExceptionHandling();
        $this->assertTrue(true);
    }

    /**
     *
     *
     */
    public function it_returns_a_relationship_to_translations_adhering_to_json_api_spec()
    {
        /** set up our world */
        \Lang::setLocale('en');

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
     * @test
     */
    public function it_includes_related_resource_objects_for_translations_when_an_include_query_param_to_translations_is_given()
    {
        /** set up our world */
        \Lang::setLocale('en');

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
}
