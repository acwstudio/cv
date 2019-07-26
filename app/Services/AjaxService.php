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
        if($data['model'] === 'user'){
            /** @var User $user */
            $user = $this->user->getById($data['id']);

            $user->update(['active' => $data['value']]);
        }

        return response()->json($user);
    }
}