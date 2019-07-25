<?php

namespace App\Http\Controllers\Admin;

use App\Services\DropzoneService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Image\Exceptions\InvalidManipulation;

/**
 * Class DropzoneController
 *
 * @package App\Http\Controllers\Admin
 */
class DropzoneController extends Controller
{
    protected $dropzone;

    /**
     * DropzoneController constructor.
     *
     * @param DropzoneService $dropzoneService
     */
    public function __construct(DropzoneService $dropzoneService)
    {
        $this->dropzone = $dropzoneService;
    }

    /**
     * @param Request $request
     * @return string
     * @throws InvalidManipulation
     */
    public function store(Request $request)
    {
        return $this->dropzone->srvStore($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        return $this->dropzone->srvDelete($request);
    }

}
