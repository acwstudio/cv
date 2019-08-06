<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\BlogService;
use App\Services\PostService;
use Illuminate\Http\Request;

/**
 * Class BlogController
 *
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    protected $blog;

    /**
     * BlogController constructor.
     *
     * @param PostService $postService
     */
    public function __construct(BlogService $blogService)
    {
        $this->blog = $blogService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function index()
    {
//        $posts = $this->blog->srvPostsList();
        return $this->blog->srvPostsList();

//        return view('blog.blog', compact('posts'));

    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function show(int $id)
    {
        return $this->blog->srvPost($id);
    }
}
