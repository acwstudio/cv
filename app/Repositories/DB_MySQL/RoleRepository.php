<?php


namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\RoleInterface;

/**
 * Class RoleRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class RoleRepository extends BaseRepository implements RoleInterface
{
    protected $modelName = '\App\Role';
}