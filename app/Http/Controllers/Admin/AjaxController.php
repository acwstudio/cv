<?php

namespace App\Http\Controllers\Admin;

use App\Services\AjaxService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AjaxController
 *
 * @package App\Http\Controllers\Admin
 */
class AjaxController extends Controller
{
    protected $model;

    /**
     * AjaxController constructor.
     *
     * @param AjaxService $ajaxService
     */
    public function __construct(AjaxService $ajaxService)
    {
        $this->model = $ajaxService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activator(Request $request)
    {
        $user = $this->model->srvActivator($request->all());

        return response()->json($user);
    }
}
