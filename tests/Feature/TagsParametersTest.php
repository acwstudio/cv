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
}
