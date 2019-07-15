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
     * @param array $relations
     * @return Collection
     */
    public function getAllPosts(array $relations = []): Collection;
}