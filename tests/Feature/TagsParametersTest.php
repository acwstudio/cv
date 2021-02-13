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
 * Class TagsParametersTest
 * @package Tests\Feature
 */
class TagsParametersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     */
    public function it_can_sort_tags_by_name_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $tags = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            return factory(Tag::class)->create([
                'alias' => $alias
            ]);
        });

        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'ru',
            ]));
        }

        $this->get('/api/v1/tags?sort=name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '3',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => 'Anna',
                            'created_at' => $tags[2]->created_at->toJSON(),
                            'updated_at' => $tags[2]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Anna'
                            ]
                        ]
                    ],
                    [
                        "id" => '1',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => 'Bertram',
                            'created_at' => $tags[0]->created_at->toJSON(),
                            'updated_at' => $tags[0]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Bertram'
                            ]
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => 'Claus',
                            'created_at' => $tags[1]->created_at->toJSON(),
                            'updated_at' => $tags[1]->updated_at->toJSON(),
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
    public function it_can_sort_tags_by_name_in_descending_order_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        /** run the code to be tested */
        $tags = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            return factory(Tag::class)->create([
                'alias' => $alias
            ]);
        });

        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'ru',
            ]));
        }

        $this->get('/api/v1/tags?sort=-name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '2',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => 'Claus',
                            'created_at' => $tags[1]->created_at->toJSON(),
                            'updated_at' => $tags[1]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Claus'
                            ]
                        ]
                    ],
                    [
                        "id" => '1',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => 'Bertram',
                            'created_at' => $tags[0]->created_at->toJSON(),
                            'updated_at' => $tags[0]->updated_at->toJSON(),
                            'translation' => [
                                'name' => 'Bertram'
                            ]
                        ]
                    ],
                    [
                        "id" => '3',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => 'Anna',
                            'created_at' => $tags[2]->created_at->toJSON(),
                            'updated_at' => $tags[2]->updated_at->toJSON(),
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
    public function it_can_sort_tags_by_multiple_attributes_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $tags = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            if($alias === 'Bertram'){
                return factory(Tag::class)->create([
                    'alias' => $alias,
                    'created_at' => now()->addSeconds(3),
                ]);
            }

            return factory(Tag::class)->create([
                'alias' => $alias,
            ]);
        });

        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/tags?sort=created_at,name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertStatus(200)->assertJson([
            "data" => [
                [
                    "id" => '3',
                    "type" => "tags",
                    "attributes" => [
                        'alias' => 'Anna',
                        'created_at' => $tags[2]->created_at->toJSON(),
                        'updated_at' => $tags[2]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Anna'
                        ]
                    ]
                ],
                [
                    "id" => '2',
                    "type" => "tags",
                    "attributes" => [
                        'alias' => 'Claus',
                        'created_at' => $tags[1]->created_at->toJSON(),
                        'updated_at' => $tags[1]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Claus'
                        ]
                    ]
                ],
                [
                    "id" => '1',
                    "type" => "tags",
                    "attributes" => [
                        'alias' => 'Bertram',
                        'created_at' => $tags[0]->created_at->toJSON(),
                        'updated_at' => $tags[0]->updated_at->toJSON(),
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
    public function it_can_sort_tags_by_multiple_attributes_in_descending_order_through_a_sort_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $tags = collect([
            'Bertram',
            'Claus',
            'Anna',
        ])->map(function($alias){
            if($alias === 'Bertram'){
                return factory(Tag::class)->create([
                    'alias' => $alias,
                    'created_at' => now()->addSeconds(3),
                ]);
            }

            return factory(Tag::class)->create([
                'alias' => $alias,
            ]);
        });

        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/tags?sort=-created_at,name', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])->assertStatus(200)->assertJson([
            "data" => [
                [
                    "id" => '1',
                    "type" => "tags",
                    "attributes" => [
                        'alias' => 'Bertram',
                        'created_at' => $tags[0]->created_at->toJSON(),
                        'updated_at' => $tags[0]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Bertram'
                        ]
                    ]
                ],
                [
                    "id" => '3',
                    "type" => "tags",
                    "attributes" => [
                        'alias' => 'Anna',
                        'created_at' => $tags[2]->created_at->toJSON(),
                        'updated_at' => $tags[2]->updated_at->toJSON(),
                        'translation' => [
                            'name' => 'Anna'
                        ]
                    ]
                ],
                [
                    "id" => '2',
                    "type" => "tags",
                    "attributes" => [
                        'alias' => 'Claus',
                        'created_at' => $tags[1]->created_at->toJSON(),
                        'updated_at' => $tags[1]->updated_at->toJSON(),
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
    public function it_can_paginate_tags_through_a_page_query_parameter()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $tags = factory(Tag::class, 10)->create();

        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/tags?page[size]=5&page[number]=1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '1',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[0]->alias,
                            'created_at' => $tags[0]->created_at->toJSON(),
                            'updated_at' => $tags[0]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[1]->alias,
                            'created_at' => $tags[1]->created_at->toJSON(),
                            'updated_at' => $tags[1]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '3',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[2]->alias,
                            'created_at' => $tags[2]->created_at->toJSON(),
                            'updated_at' => $tags[2]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '4',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[3]->alias,
                            'created_at' => $tags[3]->created_at->toJSON(),
                            'updated_at' => $tags[3]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '5',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[4]->alias,
                            'created_at' => $tags[4]->created_at->toJSON(),
                            'updated_at' => $tags[4]->updated_at->toJSON(),
                        ]
                    ],
                ],
                'links' => [
                    'first' => route('api.tags.index', ['page[size]' => 5, 'page[number]' => 1]),
                    'last' => route('api.tags.index', ['page[size]' => 5, 'page[number]' => 2]),
                    'prev' => null,
                    'next' => route('api.tags.index', ['page[size]' => 5, 'page[number]' => 2]),
                ]
            ]);
    }

    /**
     * @test
     * @watch
     */
    public function it_can_paginate_tags_through_a_page_query_parameter_and_show_different_pages()
    {
        /** set up our world */
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $tags = factory(Tag::class, 10)->create();

        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'en',
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'name' => $tag->alias,
                'locale' => 'ru',
            ]));
        }

        /** run the code to be tested */
        $this->get('/api/v1/tags?page[size]=5&page[number]=2', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            /** make all of our assertions */
            ->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '6',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[5]->alias,
                            'created_at' => $tags[5]->created_at->toJSON(),
                            'updated_at' => $tags[5]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '7',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[6]->alias,
                            'created_at' => $tags[6]->created_at->toJSON(),
                            'updated_at' => $tags[6]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '8',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[7]->alias,
                            'created_at' => $tags[7]->created_at->toJSON(),
                            'updated_at' => $tags[7]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '9',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[8]->alias,
                            'created_at' => $tags[8]->created_at->toJSON(),
                            'updated_at' => $tags[8]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '10',
                        "type" => "tags",
                        "attributes" => [
                            'alias' => $tags[9]->alias,
                            'created_at' => $tags[9]->created_at->toJSON(),
                            'updated_at' => $tags[9]->updated_at->toJSON(),
                        ]
                    ],
                ],
                'links' => [
                    'first' => route('api.tags.index', ['page[size]' => 5, 'page[number]' => 1]),
                    'last' => route('api.tags.index', ['page[size]' => 5, 'page[number]' => 2]),
                    'prev' => route('api.tags.index', ['page[size]' => 5, 'page[number]' => 1]),
                    'next' => null,
                ]
            ]);
    }
}
