<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\PostInterface;
use App\Repositories\Contracts\TagInterface;
use App\Traits\ManageImages;
use Auth;
use File;
use Session;

/**
 * Class PostService
 *
 * @package App\Services
 */
class PostService
{
    use ManageImages;

    protected $srv_post;
    protected $category;
    protected $tag;

    /**
     * PostService constructor.
     *
     * @param PostInterface $post
     */
    public function __construct(PostInterface $post, CategoryInterface $category, TagInterface $tag)
    {
        $this->srv_post = $post;
        $this->category = $category;
        $this->tag = $tag;
        $this->setItemsFromConfig('preset');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvIndex()
    {
        $posts = $this->srv_post->getAll([
            'category.translations', 'category', 'tags', 'tags.translations', 'user', 'translations'
        ]);

        $image_dir = asset('/') . $this->post['path'];
        $dummy_path = asset('/') . $this->post['dummy'] . 'post.jpg';

        foreach ($posts as $item) {
            $image_path = $image_dir . $item->image_name . '.' . $item->image_extension;

            if (file_exists(public_path('/') . $this->post['path'] . $item->image_name . '.' . $item->image_extension)) {
                $item->image_path = $image_path . '?' . time();
            } else {
                $item->image_path = $dummy_path;
            }

            $item->isAdmin = Auth::user()->hasRole('admin');
            $item->page = Session::get('page');
        }

        $transDataTable = collect(__('jsPlugins.datatable'))->toJson();
        $transSwal = collect(__('jsPlugins.swal.global'))->merge(collect(__('jsPlugins.swal.post')));

        $data = compact('posts', 'transDataTable', 'transSwal');

        return view('back.post.index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function srvCreate()
    {
        $temp_path = public_path('/') . $this->post['temp'];
        $files = File::files($temp_path);
        // clean temporary files
        if ($files) {
            File::cleanDirectory($temp_path);
        }

        $categories = $this->category->getAll();
        $tags = $this->tag->getAll();

        $transSwal = collect(__('jsPlugins.swal.global'))->merge(collect(__('jsPlugins.swal.post')));

        $data = compact('categories', 'tags', 'transSwal');

        return view('back.post.create', $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function srvStore(array $data)
    {
        $temp_path = public_path('/') . $this->post['temp'];
        $post_path = public_path('/') . $this->post['path'];

        $files = File::files($temp_path);

        $post = [
            'user_id' => Auth::user()->id,
            'category_id' => $data['category'],
            'image_name' => 'post-',
            'image_extension' => 'jpg',
            'active' => isset($data['active']) ? 1 : 0,
            app()->getLocale() => [
                'title' => $data['title'],
                'body' => $data['body'],
            ],
        ];

        $post_new = $this->srv_post->store($post);

        $this->srv_post->pivotPostTag($post_new->id, $data['tag']);

        if ($files) {

            $post['image_name'] = 'post-' . $post_new->id;
            $post['image_extension'] = $files[0]->getExtension();

            $this->srv_post->update($post_new->id, $post);

            $imagePost = $post['image_name'] . '.' . $post['image_extension'];
            File::move($temp_path . $files[0]->getFilename(), $post_path . $imagePost);

        }

        session()->flash('sw-success', __('jsPlugins.swal.post.textCreate'));

        return $post_new;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvShow($id)
    {
        $image_dir = asset('/') . $this->post['path'];
        $dummy_path = asset('/') . $this->post['dummy'] . 'post.jpg';

        $postItem = $this->srv_post->getById($id);
        $image_path = $image_dir . $postItem->image_name . '.' . $postItem->image_extension;

        if (file_exists(public_path('/') . $this->post['path'] . $postItem->image_name . '.' . $postItem->image_extension)) {
            $postItem->image_path = $image_path . '?' . time();
        } else {
            $postItem->image_path = $dummy_path;
        }

        return $postItem;
    }

}