<?php

namespace Tests\Feature;

use App\Tag;
use App\TagTranslation;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class TagsTest
 * @package Tests\Feature
 */
class TagsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_returns_a_tag_as_a_resource_object()
    {
        app()->setLocale('en');

        factory(Tag::class)->create()->each(function ($tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });
        $tag = Tag::find(1);

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->getJson('/api/v1/tags/1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertStatus(200)->assertJson([
            'data' => [
                'id' => '1',
                'type' => 'tags',
                'attributes' => [
                    'alias' => $tag->alias,
                    'created_at' => $tag->created_at->toJson(),
                    'updated_at' => $tag->updated_at->toJson(),
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => $tag->name,
                        'created_at' => $tag->translate(app()->getLocale())->created_at->toJson(),
                        'updated_at' => $tag->translate(app()->getLocale())->updated_at->toJson(),
                    ]
                ]
            ]
        ]);
    }

    /**
     * @test
     *
     */
    public function it_returns_all_tags_as_a_collection_of_resource_objects()
    {
        app()->setLocale('en');

        factory(Tag::class, 3)->create()->each(function ($tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $tags = Tag::all();

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->getJson('/api/v1/tags', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertStatus(200)->assertJson([
            'data' => [
                [
                    'id' => '1',
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => $tags[0]->alias,
                        'created_at' => $tags[0]->created_at->toJson(),
                        'updated_at' => $tags[0]->updated_at->toJson(),
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => $tags[0]->name,
                            'created_at' => $tags[0]->translate(app()->getLocale())
                                ->created_at->toJson(),
                            'updated_at' => $tags[0]->translate(app()->getLocale())
                                ->updated_at->toJson()
                        ]
                    ]
                ],
                [
                    'id' => '2',
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => $tags[1]->alias,
                        'created_at' => $tags[1]->created_at->toJson(),
                        'updated_at' => $tags[1]->updated_at->toJson(),
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => $tags[1]->name,
                            'created_at' => $tags[0]->translate(app()->getLocale())
                                ->created_at->toJson(),
                            'updated_at' => $tags[0]->translate(app()->getLocale())
                                ->updated_at->toJson()
                        ]
                    ]
                ],
                [
                    'id' => '3',
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => $tags[2]->alias,
                        'created_at' => $tags[2]->created_at->toJson(),
                        'updated_at' => $tags[2]->updated_at->toJson(),
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => $tags[2]->name,
                            'created_at' => $tags[0]->translate(app()->getLocale())
                                ->created_at->toJson(),
                            'updated_at' => $tags[0]->translate(app()->getLocale())
                                ->updated_at->toJson()
                        ]
                    ]
                ]

            ]
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_create_a_tag_of_en_locale_from_a_resource_object()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'tag_alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Tag Test'
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
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => 'tag_alias',
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => 'Tag Test',
                        ]
                    ]
                ]
            ])->assertHeader('Location', url('/api/v1/tags/1'));

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => 'tag_alias'
        ]);
        $this->assertDatabaseHas('tag_translations', [
            'id' => '1',
            'tag_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Tag Test'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_create_a_tag_of_ru_locale_from_a_resource_object()
    {
        app()->setLocale('ru');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'tag_alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Тег Тест'
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
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => 'tag_alias',
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'name' => 'Тег Тест',
                        ]
                    ]
                ]
            ])->assertHeader('Location', url('/api/v1/tags/1'));

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => 'tag_alias'
        ]);
        $this->assertDatabaseHas('tag_translations', [
            'id' => '1',
            'tag_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Тег Тест'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_update_a_tag_of_en_locale_from_a_resource_object()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Tag::class)->create()->each(function ($tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        /** run the code to be tested */
        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'another_alias',
                    'translation' => [
                        'name' => 'Another Tag'
                    ]
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
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => 'another_alias',
                        'translation' => [
                            'name' => 'Another Tag'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => 'another_alias'
        ]);
        $this->assertDatabaseHas('tag_translations', [
            'id' => '1',
            'tag_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Another Tag'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_update_a_tag_of_ru_locale_from_a_resource_object()
    {
        app()->setLocale('ru');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Tag::class)->create()->each(function ($tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'another_alias',
                    'translation' => [
                        'name' => 'Другой Тэг'
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
                    'type' => 'tags',
                    'attributes' => [
                        'alias' => 'another_alias',
                        'translation' => [
                            'name' => 'Другой Тэг'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => 'another_alias'
        ]);
        $this->assertDatabaseHas('tag_translations', [
            'id' => '2',
            'tag_id' => '1',
            'locale' => app()->getLocale(),
            'name' => 'Другой Тэг'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_can_delete_a_tag_with_all_translations_through_a_delete_request()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Tag::class)->create()->each(function ($tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'ru',
            ]));
        });

        $tag = Tag::find(1);

        $this->delete('/api/v1/tags/1', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])
            ->assertStatus(204);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => $tag->alias
        ]);
    }
}
