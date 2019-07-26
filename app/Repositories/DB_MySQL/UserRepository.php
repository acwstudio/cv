<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\UserInterface;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class UserRepository extends BaseRepository implements UserInterface
{
    protected $modelName = '\App\User';

    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        $user = $this->getNewInstance()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => isset($data['active']) ? true : false,
        ]);

        /** @var $user User */
        $user->assignRole($data['role']);

        return $user;
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $user = $this->getById($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => isset($data['active']) ? true : false,
            'image_name' => $data['image_name'],
            'image_extension' => $data['image_extension'],
        ]);
    }

}