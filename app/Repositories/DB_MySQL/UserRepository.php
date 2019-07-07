<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\UserInterface;

/**
 * Class UserRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class UserRepository extends BaseRepository implements UserInterface
{
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
}