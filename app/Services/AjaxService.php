<?php

namespace App\Services;

use App\Repositories\Contracts\PostInterface;
use App\Repositories\Contracts\UserInterface;

/**
 * Class AjaxService
 *
 * @package App\Services
 */
class AjaxService
{
    protected $user;
    protected $post;

    /**
     * AjaxService constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user, PostInterface $post)
    {
        $this->user = $user;
        $this->post = $post;
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
            $model = $this->user->update($data['id'], $active);
        }

        if($data['model'] === 'post'){
            $model = $this->post->update($data['id'], $active);
        }

        return $model->active;
    }
}