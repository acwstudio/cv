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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->blog->srvPostsList();

        return view('blog.blog', compact('posts'));
    }

    public function show()
    {

    }
}
