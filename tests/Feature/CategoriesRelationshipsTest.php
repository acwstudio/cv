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
     * @test
     * @watch
     */
    public function it_returns_a_relationship_to_translations_adhearing_to_json_api_spec()
    {
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
        dump((string)$category->translations[0]->id);
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
}
