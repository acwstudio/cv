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
//    use RegistersUsers;

    protected $modelName = '\App\User';

    /**
     * @param integer $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getById(int $id, array $relations = [])
    {
        // TODO: Implement getById() method.
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBy(string $field, $value)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => isset($data['active']) ? true : false,
        ]);

        $data['role'] ? $user->assignRole($data['role']) : $user->assignRole('user');

        return $user;
    }

}