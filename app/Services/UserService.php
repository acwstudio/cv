<?php

namespace App\Services;

use App\Repositories\Contracts\RoleInterface;
use App\Repositories\Contracts\UserInterface;
use Auth;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService
{
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
        }

        return $users;
    }

    public function srvCreate()
    {
        $roles = $this->role->getAll();

        return $roles;
    }
}