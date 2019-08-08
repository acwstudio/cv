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

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function postUpdate(int $id, array $data)
    {
        $post = $this->update($id, $data);
        /** @var $post \App\Post */
        $post->tags()->sync($data['tag']);

        return $post;
    }
}