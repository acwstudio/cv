<?php

namespace App\Repositories\DB_MySQL;

use App\Repositories\Contracts\PostInterface;

/**
 * Class PostRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class PostRepository extends BaseRepository implements PostInterface
{
    protected $modelName = '\App\Post';

    /**
     * @param int $id
     * @param array $tags
     * @return mixed
     */
    public function pivotPostTag(int $id, array $tags)
    {
        /** @var \App\Post $post */
        $post = $this->getById($id);
        $post->tags()->attach($tags);
    }
}