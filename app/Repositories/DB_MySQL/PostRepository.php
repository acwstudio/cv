<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\PostInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PostRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class PostRepository extends BaseRepository implements PostInterface
{
    protected $modelName = '\App\Post';

}