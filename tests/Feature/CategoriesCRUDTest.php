<?php


namespace Tests\Feature;


use App\Category;
use App\CategoryTranslation;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class CategoriesTest
 * @package Tests\Feature
 */
class CategoriesCRUDTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_returns_a_category_as_resource_object()
    {
        app()->setLocale('en');
//
        factory(Category::class)->create()->each(function ($category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });
        $category = Category::find(1);

        $user = factory(User::class)->create();
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
                    'attributes' => [
                        'alias' => $category->alias,
                        'created_at' => $category->created_at->toJson(),
                        'updated_at' => $category->updated_at->toJson(),
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => $category->name,
                            'created_at' => $category->translate(app()->getLocale())
                                ->created_at->toJson(),
                            'updated_at' => $category->translate(app()->getLocale())
                                ->updated_at->toJson(),
                        ]
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
        app()->setLocale('en');

        factory(Category::class, 3)->create()->each(function ($category) {
            /** @var Category $category */
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

        $this->getJson('/api/v1/categories', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
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
                            'translation' => [
                                'locale' => app()->getLocale(),
                                'name' => $categories[0]->name,
                                'created_at' => $categories[0]->translate(app()->getLocale())
                                    ->created_at->toJson(),
                                'updated_at' => $categories[0]->translate(app()->getLocale())
                                    ->updated_at->toJson()
                            ]
                        ]
                    ],
                    [
                        'id' => '2',
                        'type' => 'categories',
                        'attributes' => [
                            'alias' => $categories[1]->alias,
                            'created_at' => $categories[1]->created_at->toJson(),
                            'updated_at' => $categories[1]->updated_at->toJson(),
                            'translation' => [
                                'locale' => app()->getLocale(),
                                'name' => $categories[1]->name,
                                'created_at' => $categories[1]->translate(app()->getLocale())
                                    ->created_at->toJson(),
                                'updated_at' => $categories[1]->translate(app()->getLocale())
                                    ->updated_at->toJson()
                            ]
                        ]
                    ],
                    [
                        'id' => '3',
                        'type' => 'categories',
                        'attributes' => [
                            'alias' => $categories[2]->alias,
                            'created_at' => $categories[2]->created_at->toJson(),
                            'updated_at' => $categories[2]->updated_at->toJson(),
                            'translation' => [
                                'locale' => app()->getLocale(),
                                'name' => $categories[2]->name,
                                'created_at' => $categories[2]->translate(app()->getLocale())
                                    ->created_at->toJson(),
                                'updated_at' => $categories[2]->translate(app()->getLocale())
                                    ->updated_at->toJson()
                            ]
                        ]
                    ],
                ],

            ]);
    }

    /**
     * @test
     *
     */
    public function it_can_create_a_category_of_en_locale_from_a_resource_object()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'category_alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Category Test'
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => 'category_alias',
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => 'Category Test',
                        ]
                    ]
                ]
            ])->assertHeader('Location', url('/api/v1/categories/1'));

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => 'category_alias'
        ]);
        $this->assertDatabaseHas('category_translations', [
            'id' => '1',
            'category_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Category Test'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_create_a_category_of_ru_locale_from_a_resource_object()
    {
        app()->setLocale('ru');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/categories', [
            'data' => [
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'category_alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Категория Тест'
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => 'category_alias',
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => 'Категория Тест',
                        ]
                    ]
                ]
            ])->assertHeader('Location', url('/api/v1/categories/1'));

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => 'category_alias'
        ]);
        $this->assertDatabaseHas('category_translations', [
            'id' => '1',
            'category_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Категория Тест'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_update_a_category_of_en_locale_from_a_resource_object()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Category::class)->create()->each(function ($category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'another_alias',
                    'translation' => [
                        'name' => 'Another Category'
                    ]
                ]
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => 'another_alias',
                        'translation' => [
                            'name' => 'Another Category'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => 'another_alias'
        ]);

        $this->assertDatabaseHas('category_translations', [
            'id' => '1',
            'category_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Another Category'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_update_a_category_of_ru_locale_from_a_resource_object()
    {
        app()->setLocale('ru');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Category::class)->create()->each(function ($category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'another_alias',
                    'translation' => [
                        'name' => 'Другая категория'
                    ]
                ]
            ]
        ],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => 'another_alias',
                        'translation' => [
                            'name' => 'Другая категория'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => 'another_alias'
        ]);

        $this->assertDatabaseHas('category_translations', [
            'id' => '2',
            'category_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Другая категория'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_delete_a_category_with_all_translations_through_a_delete_request()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Category::class)->create()->each(function ($category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en',
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $category = Category::find(1);

        $this->delete('/api/v1/categories/1', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            ->assertStatus(204);

        $this->assertDatabaseMissing('categories', [
            'id' => '1',
            'alias' => $category->alias
        ]);
    }

}
