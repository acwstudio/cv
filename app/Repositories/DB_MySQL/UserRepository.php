<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\UserInterface;
use App\User;

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
        $user = $this->store($data);
        /** @var $user User */
        $user->assignRole($data['role']);

        return $user;
    }

}