<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryTranslation;
use App\User;
use Carbon\Carbon;
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
     *
     */
    public function it_validates_that_id_member_is_given_when_updating_a_category()
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

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
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
                        'details' => 'The data.id field is required.',
                        'source'  => [
                            'pointer' => '/data/id',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_id_member_is_a_string_when_updating_a_category()
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

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => 1,
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
                        'details' => 'The data.id must be a string.',
                        'source'  => [
                            'pointer' => '/data/id',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => $category->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_type_member_is_given_when_updating_a_category()
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

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => '',
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
    public function it_validates_that_type_member_has_the_value_of_categories_when_updating_an_category()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $category = factory(Category::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'category',
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
    public function it_validates_that_attributes_member_is_an_object_given_when_updating_a_category()
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
    public function it_validates_that_alias_attribute_is_a_string_when_updating_an_category()
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

    /**
     * @test
     */
    public function it_validates_that_translation_attribute_is_an_object_given_when_updating_a_category()
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

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'translation' => 'not an object'
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
                        'details' => 'The data.attributes.translation must be an array.',
                        'source'  => [
                            'pointer' => '/data/attributes/translation',
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
     *
     */
    public function it_validates_that_locale_translation_attribute_has_the_value_of_en_when_updating_a_category()
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


        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => 'ru',
                    ]
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
                        'title' => 'Validation Error',
                        'details' => 'The selected data.attributes.translation.locale is invalid.',
                        'source' => [
                            'pointer' => '/data/attributes/translation/locale',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => $category->alias
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_locale_translation_attribute_has_the_value_of_ru_when_updating_a_category()
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
        $category = Category::find(1);

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => 'en',
                    ]
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
                        'title' => 'Validation Error',
                        'details' => 'The selected data.attributes.translation.locale is invalid.',
                        'source' => [
                            'pointer' => '/data/attributes/translation/locale',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => $category->alias
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_name_translation_attribute_is_string_when_updating_a_category()
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

        $this->patchJson('/api/v1/categories/1', [
            'data' => [
                'id' => '1',
                'type' => 'categories',
                'attributes' => [
                    'translation' => [
                        'name' => 47
                    ]
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
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.translation.name must be a string.',
                        'source' => [
                            'pointer' => '/data/attributes/translation/name',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => '1',
            'alias' => $category->alias
        ]);
    }
}
