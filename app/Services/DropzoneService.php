<?php

namespace App\Services;

use App\Traits\ManageImages;
use Illuminate\Http\Request;

/**
 * Class DropzoneService
 *
 * @package App\Services
 */
class DropzoneService
{
    protected $directories = [];
    protected $img_size;

    use ManageImages;

    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @return string
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function srvStore($request)
    {
        $this->setItemsFromConfig('preset');

        $useImage = $request->useImage;
        $propsImage = $this->$useImage;

        return $this->storeImage($propsImage, $request);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function srvDelete($request)
    {
        $this->setItemsFromConfig('preset');

        $useImage = $request->useImage;
        $propsImage = $this->$useImage;

        return $this->deleteImage($propsImage, $request);
    }
}