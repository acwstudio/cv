<?php

namespace App\Services;

use App\Repositories\Contracts\UserInterface;
use App\User;

/**
 * Class AjaxService
 *
 * @package App\Services
 */
class AjaxService
{
    protected $user;

    /**
     * AjaxService constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function srvActivator(array $data)
    {
        $active = array_filter($data, function($key) {
            return $key === 'active';
        }, $flag = ARRAY_FILTER_USE_KEY);

        if($data['model'] === 'user'){
            $user = $this->user->update($data['id'], $active);
        }

        return response()->json($user);
    }
}