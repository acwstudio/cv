<?php

namespace App\Services;
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

    /**
     * UserService constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function srvIndex()
    {
        $users = $this->user->getAll();

        foreach ($users as $item) {

            $perms = $item->getPermissionsViaRoles()->pluck('name');
            $roles = $item->getRoleNames();
            $item->perms = $perms;
            $item->roles = $roles;
            $item->isAdmin = Auth::user()->hasRole('admin');

        }
//        dd($users);
        return $users;
    }
}