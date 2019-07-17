<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\CategoryInterface;


/**
 * Class CategoryRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class CategoryRepository extends BaseRepository implements CategoryInterface
{
    protected $modelName = '\App\Category';
}