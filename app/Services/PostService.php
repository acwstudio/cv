<?php

namespace App\Services;

use App\Repositories\Contracts\PostInterface;
use Auth;

/**
 * Class PostService
 *
 * @package App\Services
 */
class PostService
{
    protected $post;

    /**
     * PostService constructor.
     *
     * @param PostInterface $post
     */
    public function __construct(PostInterface $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvIndex()
    {
        $posts = $this->post->getAllPosts(['category.translations', 'category', 'tags', 'tags.translations', 'user', 'translations']);

        foreach ($posts as $post) {
            if (Auth::user()) {
                $post->isAdmin = Auth::user()->hasRole('admin');
            }
        }
       // dd($posts->find(3));
        return $posts;
    }
}