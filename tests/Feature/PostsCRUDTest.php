<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryTranslation;
use App\Post;
use App\PostTranslation;
use App\Tag;
use App\TagTranslation;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostsCRUDTest
 * @package Tests\Feature
 */
class PostsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_returns_an_post_as_a_resource_object()
    {
        app()->setLocale('en');

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        factory(Category::class)->create()->each(function ($category) {
            /** @var Category $category */
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'en'
            ]));
            $category->translations()->save(factory(CategoryTranslation::class)->make([
                'locale' => 'ru'
            ]));
        });
        $category = Category::first();

        factory(Tag::class)->create()->each(function ($tag) {
            /** @var Tag $tag */
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'en'
            ]));
            $tag->translations()->save(factory(TagTranslation::class)->make([
                'locale' => 'ru'
            ]));
        });
        $tag = Tag::first();

        factory(Post::class)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'image_name' => 'img-1',
        ])->each(function ($post) {
            /** @var Post $post */
            $post->translations()->save(factory(PostTranslation::class)->make([
                'locale' => 'en'
            ]));
            $post->translations()->save(factory(PostTranslation::class)->make([
                'locale' => 'ru'
            ]));
        });
        $post = Post::first();

        $this->getJson('/api/v1/posts/1', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'posts',
                    'attributes' => [
                        'user_id' => $user->id,
                        'category_id' => $category->id,
                        'active' => $post->active,
                        'image_name' => $post->image_name,
                        'image_extension' => $post->image_extension,
                        'created_at' => $post->created_at->toJson(),
                        'updated_at' => $post->updated_at->toJson(),
                        'translation' => [
                            'locale' => app()->getLocale(),
                            'title' => $post->translate(app()->getLocale())->title,
                            'body' => $post->translate(app()->getLocale())->body,
                            'created_at' => $post->translate(app()->getLocale())
                                ->created_at->toJson(),
                            'updated_at' => $post->translate(app()->getLocale())
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
    public function it_returns_all_posts_as_a_collection_of_resource_objects()
    {
        app()->setLocale('en');

        $users = factory(User::class, 3)->create();
        Passport::actingAs($users->first());
        dump($users->first());

    }
}
