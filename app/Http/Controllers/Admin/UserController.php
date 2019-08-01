<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    use HasRoles;

    protected $user;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->user = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return UserService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        return $this->user->srvIndex();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function create()
    {
        return $this->user->srvCreate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $this->user->srvRegister($request->all());

        return redirect()->route('users.index')
        ->with('success','last');
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
        $user = $this->user->srvShow($id);
        $show = view('back.user.show', compact('user'))->render();

        return $show;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        return $this->user->srvEdit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy($id)
    {
        $result = $this->user->srvDestroy($id);

        return $result;
    }
}
