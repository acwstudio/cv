<?php

namespace App\Services;

use App\Repositories\Contracts\RoleInterface;
use App\Repositories\Contracts\UserInterface;
use App\Traits\ManageImages;
use Auth;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService
{
    use ManageImages;

    protected $srv_user;
    protected $role;

    /**
     * UserService constructor.
     *
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     */
    public function __construct(UserInterface $userRepository, RoleInterface $roleRepository)
    {
        $this->srv_user = $userRepository;
        $this->role = $roleRepository;

        $this->setItemsFromConfig('preset');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function srvIndex()
    {
        $users = $this->srv_user->getAll(['posts', 'roles', 'roles.permissions']);
        $image_dir = asset('/') . $this->user['path'];
        $dummy_path = asset('/') . $this->user['dummy'] . 'user.jpg';

        foreach ($users as $item) {
            $image_path = $image_dir . $item->image_name . '.' . $item->image_extension;

            if (file_exists(public_path('/') . $this->user['path'] . $item->image_name . '.' . $item->image_extension)) {
                $item->image_path = $image_path;
            } else {
                $item->image_path = $dummy_path;
            }

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
        $temp_path = public_path('/') . $this->user['temp'];
        $files = File::files($temp_path);
        // clean temporary files
        if ($files) {
            File::cleanDirectory($temp_path);
        }

        $roles = $this->role->getAll();

        return $roles;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function srvRegister(array $data)
    {
        $temp_path = public_path('/') . $this->user['temp'];
        $user_path = public_path('/') . $this->user['path'];

        $files = File::files($temp_path);

        isset($data['role']) ? $data['role'] : $data['role'] = 'user';
        $data['image_name'] = 'user-';
        $data['image_extension'] = 'jpg';
        $data['active'] = isset($data['active']) ? true : false;
        $data['password'] = Hash::make($data['password']);

        $user_new = $this->srv_user->register($data);

        if ($files) {

            $data['image_name'] = 'user-' . $user_new->id;
            $data['image_extension'] = $files[0]->getExtension();

            $this->srv_user->update($user_new->id, $data);

            $imageUser = $data['image_name'] . '.'  . $data['image_extension'];
            File::move($temp_path . $files[0]->getFilename(), $user_path . $imageUser);

        }

        return $user_new;
    }

}