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


}