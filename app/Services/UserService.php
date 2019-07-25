<?php

namespace App\Services;

use App\Repositories\Contracts\RoleInterface;
use App\Repositories\Contracts\UserInterface;
use Auth;
use Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\User;
use Illuminate\Support\Facades\Session;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService
{
    use RegistersUsers;

    protected $user;
    protected $role;

    /**
     * UserService constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $userRepository, RoleInterface $roleRepository)
    {
        $this->user = $userRepository;
        $this->role = $roleRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function srvIndex()
    {
        $users = $this->user->getAll(['posts', 'roles', 'roles.permissions']);

        foreach ($users as $item) {
            $item->isAdmin = Auth::user()->hasRole('admin');
            $item->page = Session::get('success');
        }

        return $users;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvCreate()
    {
        $roles = $this->role->getAll();

        return $roles;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function srvRegister(array $data)
    {
        return $this->user->register($data);
    }
}