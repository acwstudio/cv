<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PostInterface
 *
 * @package App\Repositories\Contracts
 */
interface PostInterface extends BaseInterface
{
    /**
     * @param int $id
     * @param array $tags
     * @return mixed
     */
    public function pivotPostTag(int $id, array $tags);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function postUpdate(int $id, array $data);
}