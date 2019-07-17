<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\TagInterface;

/**
 * Class TagRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class TagRepository extends BaseRepository implements TagInterface
{
    protected $modelName = '\App\Tag';
}