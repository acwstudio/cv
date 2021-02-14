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
 * Class TagsUpdateValidationTest
 * @package Tests\Feature
 */
class TagsUpdateValidationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_validates_that_id_member_is_given_when_updating_a_tag()
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

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_id_member_is_a_string_when_updating_a_tag()
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

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => 1,
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_type_member_is_given_when_updating_a_tag()
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

        $this->patchJson('/api/v1/tags/1', [
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

        $this->assertDatabaseHas('tags', [
            'id' => 1,
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_type_member_has_the_value_of_tags_when_updating_an_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $tag = factory(Tag::class)->create();

        /** run the code to be tested */
        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tag',
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

        $this->assertDatabaseHas('tags', [
            'id' => 1,
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_attributes_member_is_an_object_given_when_updating_a_tag()
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

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => 1,
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_alias_attribute_is_a_string_when_updating_an_tag()
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

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => 1,
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     */
    public function it_validates_that_translation_attribute_is_an_object_given_when_updating_a_tag()
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

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => 1,
            'alias' => $tag->alias,
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_locale_translation_attribute_has_the_value_of_en_when_updating_a_tag()
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


        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => $tag->alias
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_locale_translation_attribute_has_the_value_of_ru_when_updating_a_tag()
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
        $tag = Tag::find(1);

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => $tag->alias
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_name_translation_attribute_is_string_when_updating_a_tag()
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

        $this->patchJson('/api/v1/tags/1', [
            'data' => [
                'id' => '1',
                'type' => 'tags',
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

        $this->assertDatabaseHas('tags', [
            'id' => '1',
            'alias' => $tag->alias
        ]);
    }
}
