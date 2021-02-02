<?php


namespace Tests\Feature;


use App\Category;
use App\CategoryTranslation;
use App\User;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * @watch
     */
    public function it_returns_an_category_as_resource_object()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        \Lang::setLocale('en');

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

        $this->getJson('/api/v1/categories/1')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'categories',
                    'attributes' => [
                        'alias' => $category->alias,
                        'created_at' => $category->created_at->toJson(),
                        'updated_at' => $category->updated_at->toJson(),
                        'translations' => [
                            'en' => [
                                'id' => $category->translate('en')->id,
                                'category_id' => $category->translate('en')->category_id,
                                'locale' => $category->translate('en')->locale,
                                'name' => $category->translate('en')->name,
                            ],
                            'ru' => [
                                'id' => $category->translate('ru')->id,
                                'category_id' => $category->translate('ru')->category_id,
                                'locale' => $category->translate('ru')->locale,
                                'name' => $category->translate('ru')->name,
                            ]
                        ]
                    ]
                ]
            ]);
    }


    /**
     * @test
     * @watch
     */
    public function it_returns_all_categories_as_a_collection_of_resource_objects()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        \Lang::setLocale('en');

        $test = factory(Category::class, 3)->create()->each(function ($category) {
            /** @var $category Category*/
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en'
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru'
            ]));
        });

        $categories = Category::all();

        $this->getJson('/api/v1/categories')
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
                            'translations' => [
                                'en' => [
                                    'id' => $categories[0]->translate('en')->id,
                                    'category_id' => $categories[0]->translate('en')->category_id,
                                    'locale' => $categories[0]->translate('en')->locale,
                                    'name' => $categories[0]->translate('en')->name,
                                ],
                                'ru' => [
                                    'id' => $categories[0]->translate('ru')->id,
                                    'category_id' => $categories[0]->translate('ru')->category_id,
                                    'locale' => $categories[0]->translate('ru')->locale,
                                    'name' => $categories[0]->translate('ru')->name,
                                ]
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
                            'translations' => [
                                'en' => [
                                    'id' => $categories[1]->translate('en')->id,
                                    'category_id' => $categories[1]->translate('en')->category_id,
                                    'locale' => $categories[1]->translate('en')->locale,
                                    'name' => $categories[1]->translate('en')->name,
                                ],
                                'ru' => [
                                    'id' => $categories[1]->translate('ru')->id,
                                    'category_id' => $categories[1]->translate('ru')->category_id,
                                    'locale' => $categories[1]->translate('ru')->locale,
                                    'name' => $categories[1]->translate('ru')->name,
                                ]
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
                            'translations' => [
                                'en' => [
                                    'id' => $categories[2]->translate('en')->id,
                                    'category_id' => $categories[2]->translate('en')->category_id,
                                    'locale' => $categories[2]->translate('en')->locale,
                                    'name' => $categories[2]->translate('en')->name,
                                ],
                                'ru' => [
                                    'id' => $categories[2]->translate('ru')->id,
                                    'category_id' => $categories[2]->translate('ru')->category_id,
                                    'locale' => $categories[2]->translate('ru')->locale,
                                    'name' => $categories[2]->translate('ru')->name,
                                ]
                            ]
                        ]
                    ],
                ],

            ]);
    }
}
