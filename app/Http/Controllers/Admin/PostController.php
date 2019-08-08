<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Post;
use App\Services\PostService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PostController
 *
 * @package App\Http\Controllers\Admin
 */
class PostController extends Controller
{
    protected $post;

    /**
     * PostController constructor.
     *
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->post = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->post->srvIndex();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->post->srvCreate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
//        $data = [
//            'user_id' => Auth::user()->id,
//            'category_id' => 1,
//            'image_name' => 'post-',
//            'image_extension' => 'jpg',
//            'active' => isset($data['active']) ? true : false,
//            'en' => [
//                'title' => 'test title',
//                'body' => 'bbbbbbbbbbbb',
//            ],
//            'ru' => [
//                'title' => 'тест заголовка',
//                'body' => 'чччччччччччччч',
//            ],
//        ];
//        $post = Post::create($data);
        //dd($post);
        $this->post->srvStore($request->all());

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function show($id)
    {
        $postItem = $this->post->srvShow($id);
        $show = view('back.post.show', compact('postItem'))->render();

        return $show;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param  int $id
     * @return void
     */
    public function update(PostUpdateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
