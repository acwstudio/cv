<?php

namespace App\Services;

use App\Repositories\Contracts\RoleInterface;
use App\Repositories\Contracts\UserInterface;
use App\Traits\ManageImages;
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
//    use RegistersUsers;
    use ManageImages;

    protected $srv_user;
    protected $role;

    /**
     * UserService constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $userRepository, RoleInterface $roleRepository)
    {
        $this->srv_user = $userRepository;
        $this->role = $roleRepository;

        //$this->setItemsFromConfig('preset');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function srvIndex()
    {
        $users = $this->srv_user->getAll(['posts', 'roles', 'roles.permissions']);

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
        //dd($this->user['temp']);
        isset($data['role']) ? $data['role'] : $data['role'] = 'user';
        $data['image_name'] = 'user-';

        return $this->srv_user->register($data);
    }
}