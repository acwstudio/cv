<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class TagsStoreValidationTest
 * @package Tests\Feature
 */
class TagsStoreValidationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_validates_that_the_type_member_is_given_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => '',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Some Name'
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
                        'details' => 'The data.type field is required.',
                        'source' => [
                            'pointer' => '/data/type'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_the_type_member_has_the_value_of_tags_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tagsssss',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Some Name'
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
                        'details' => 'The selected data.type is invalid.',
                        'source' => [
                            'pointer' => '/data/type'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_the_attributes_member_is_given_when_creating_a_tag()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our asserts */
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes field is required.',
                        'source' => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_the_attributes_member_is_an_object_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => 'not an object',
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
                        'details' => 'The data.attributes must be an array.',
                        'source' => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_alias_attribute_is_given_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => '',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Some Name'
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
                        'details' => 'The data.attributes.alias field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/alias'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_alias_attribute_is_a_string_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 47,
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => 'Some Name'
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
                        'details' => 'The data.attributes.alias must be a string.',
                        'source' => [
                            'pointer' => '/data/attributes/alias'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_translation_attribute_is_given_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
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
                        'details' => 'The data.attributes.translation field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/translation',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_translation_attribute_is_an_object_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
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
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.translation must be an array.',
                        'source' => [
                            'pointer' => '/data/attributes/translation',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Test Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_locale_translation_attribute_is_given_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => '',
                        'name' => 'Some Name'
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
                        'details' => 'The data.attributes.translation.locale field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/translation/locale'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_locale_translation_attribute_has_the_value_of_en_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => 'ru',
                        'name' => 'Some Name'
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

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_locale_translation_attribute_has_the_value_of_ru_when_creating_a_tag()
    {
        app()->setLocale('ru');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => 'en',
                        'name' => 'Some Name'
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

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_name_translation_attribute_is_given_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
                        'name' => ''
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
                        'details' => 'The data.attributes.translation.name field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/translation/name'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }

    /**
     * @test
     *
     */
    public function it_validates_that_name_translation_attribute_is_string_when_creating_a_tag()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->postJson('/api/v1/tags', [
            'data' => [
                'type' => 'tags',
                'attributes' => [
                    'alias' => 'Some Alias',
                    'translation' => [
                        'locale' => app()->getLocale(),
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
                            'pointer' => '/data/attributes/translation/name'
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => '1',
            'alias' => 'Some Alias'
        ]);
    }
}
