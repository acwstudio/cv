<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\PostInterface;
use App\Repositories\Contracts\TagInterface;
use App\Traits\ManageImages;
use Auth;
use File;
use Illuminate\Support\Facades\Log;
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
            'image_name' => 'post_',
            'image_extension' => 'jpg',
            'active' => isset($data['active']) ? 1 : 0,
            app()->getLocale() => [
                'title' => $data['title'],
                'body' => $data['body'],
            ],
        ];

        if (Auth::user()->getRoleNames()->first() === 'user'){

            session()->flash('sw-title', __('jsPlugins.swal.global.demoTitle'));
            session()->flash('sw-text', __('jsPlugins.swal.global.demoText'));

            Log::info('It has been tested from ' . \Request::ip());

        } else {

            $post_new = $this->srv_post->store($post);

            $this->srv_post->pivotPostTag($post_new->id, $data['tag']);

            if ($files) {

                $post['image_name'] = 'post_' . $post_new->id;
                $post['image_extension'] = $files[0]->getExtension();

                $this->srv_post->update($post_new->id, $post);

                $imagePost = $post['image_name'] . '.' . $post['image_extension'];
                File::move($temp_path . $files[0]->getFilename(), $post_path . $imagePost);

            }

            session()->flash('sw-title', __('jsPlugins.swal.post.titleCreate'));
            session()->flash('sw-text', __('jsPlugins.swal.post.textCreate'));

        }

    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvShow($id)
    {
        $image_dir = asset('/') . $this->post['path'];
        $dummy_path = asset('/') . $this->post['dummy'] . 'post.jpg';

        $postItem = $this->srv_post->getById($id, ['tags', 'category']);

        $image_path = $image_dir . $postItem->image_name . '.' . $postItem->image_extension;

        if (file_exists(public_path('/') . $this->post['path'] . $postItem->image_name . '.' . $postItem->image_extension)) {
            $postItem->image_path = $image_path . '?' . time();
        } else {
            $postItem->image_path = $dummy_path;
        }

        return $postItem;
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function srvEdit(int $id)
    {
        $postItem = $this->srv_post->getById($id,  ['tags', 'category']);
        $postItem->tagItems = $postItem->tags->pluck('id')->toArray();
        if (file_exists(public_path('/') . $this->post['path'] . $postItem->image_name . '.' . $postItem->image_extension)) {
            $postItem->path = asset('/') . $this->post['path'] . $postItem->image_name . '.' . $postItem->image_extension . '?' . time();
        } else{
            $postItem->path = asset('/') . $this->post['dummy'] . 'post.jpg';
        }

        $categories = $this->category->getAll();
        $tags = $this->tag->getAll();

        $transSwal = collect(__('jsPlugins.swal.global'))->merge(collect(__('jsPlugins.swal.post')));

        $data = compact('tags', 'categories', 'transSwal', 'postItem');

        return view('back.post.edit', $data);
    }

    /**
     * @param array $data
     * @param int $id
     */
    public function srvUpdate(array $data, int $id)
    {
        $temp_path = public_path('/') . $this->post['temp'];
        $post_path = public_path('/') . $this->post['path'];

        $files = File::files($temp_path);

        $data['active'] = isset($data['active']) ? true : false;

        if (Auth::user()->getRoleNames()->first() === 'user'){

            session()->flash('sw-title', __('jsPlugins.swal.global.demoTitle'));
            session()->flash('sw-text', __('jsPlugins.swal.global.demoText'));

            Log::info('It has been tested from ' . \Request::ip());

        } else {

            if ($files) {
                $data['image_name'] = 'post_' . $id;
                $data['image_extension'] = $files[0]->getExtension();
                $imagePost = $data['image_name'] . '.' . $data['image_extension'];
                File::move($temp_path . $files[0]->getFilename(), $post_path . $imagePost);
            }

            $this->srv_post->postUpdate($id, $data);

            session()->flash('sw-title', __('jsPlugins.swal.post.titleUpdate'));
            session()->flash('sw-text', __('jsPlugins.swal.post.textUpdate'));

        }

    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function srvDestroy(int $id)
    {
        $post = $this->srv_post->getById($id);
        $postImagePath = public_path('/') . $this->post['path'] . $post->image_name . '.' . $post->image_extension;

        if (Auth::user()->hasRole('admin')) {
            $result = $this->srv_post->destroy($id);
            if (file_exists($postImagePath)) {
                File::delete($postImagePath);
            }
        } else {
            $result = null;
        }

        return $result;
    }

}