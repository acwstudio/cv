<?php

namespace App\Repositories\Contracts;


/**
 * Interface UserInterface
 *
 * @package App\Repositories\Contracts
 */
interface UserInterface extends BaseInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);
}