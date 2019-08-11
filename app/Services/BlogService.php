<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\PostInterface;
use App\Repositories\Contracts\TagInterface;
use App\Traits\ManageImages;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Date\Date;

/**
 * Class BlogService
 *
 * @package App\Services
 */
class BlogService
{
    use ManageImages;

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
        $this->tag = $tag->getAll();
        $this->category = $category->getAll();

        Date::setLocale(app()->getLocale());

        $this->setItemsFromConfig('preset');
    }

    /**
     * @return Collection|\Illuminate\Database\Eloquent\Model
     */
    public function srvPostsList()
    {
        $image_dir = asset('/') . $this->post['path'];
        $dummy_path = asset('/') . $this->post['dummy'] . 'post.jpg';
        //dd(public_path($this->post['path']) . 'post.jpg');
        $posts = $this->blog->paginate(3);
        $posts->s_tags = $this->tag;
        $posts->s_categories = $this->category;

        foreach ($posts as $item) {
            $image_path = $image_dir . $item->image_name . '.' . $item->image_extension;

            if (file_exists(public_path('/') . $this->post['path'] . $item->image_name . '.' . $item->image_extension)) {
                $item->image_path = $image_path . '?' . time();
            } else {
                $item->image_path = $dummy_path;
            }

            $item->created = Date::make($item->created_at)->format('j F Y');
        }

//        dd($posts);
        return view('blog.blog', compact('posts'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function srvPost(int $id)
    {
        $image_dir = asset('/') . $this->post['path'];
        $dummy_path = asset('/') . $this->post['dummy'] . 'post.jpg';

        $postItem = $this->blog->getById($id);
        $posts = $this->blog->getAll();

        $image_path = $image_dir . $postItem->image_name . '.' . $postItem->image_extension;

        if (file_exists(public_path('/') . $this->post['path'] . $postItem->image_name . '.' . $postItem->image_extension)) {
            $postItem->image_path = $image_path . '?' . time();
        } else {
            $postItem->image_path = $dummy_path;
        }

        $posts->s_tags = $this->tag;
        $posts->s_categories = $this->category;

        return view('blog.post', compact('postItem', 'posts'));
    }
}