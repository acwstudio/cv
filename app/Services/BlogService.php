<?php

namespace App\Services;
use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\PostInterface;
use App\Repositories\Contracts\TagInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class BlogService
 *
 * @package App\Services
 */
class BlogService
{
    protected $blog;
    protected $tag;
    protected $category;

    /**
     * BlogService constructor.
     *
     * @param PostInterface $post
     */
    public function __construct(PostInterface $post, TagInterface $tag, CategoryInterface $category)
    {
        $this->blog = $post;
        $this->tag = $tag;
        $this->category = $category;
    }


    /**
     * @return Collection|\Illuminate\Database\Eloquent\Model
     */
    public function srvPostsList()
    {
        $posts = $this->blog
            ->paginate(3, [
                'category.translations', 'category', 'tags', 'tags.translations', 'user', 'translations'
            ]);
        //dd($posts);
        $posts->s_tags = $this->tag->getAll(['translations']);
        $posts->s_categories = $this->category->getAll(['translations']);

        return $posts;
    }
}