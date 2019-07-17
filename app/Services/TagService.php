<?php

namespace App\Services;
use App\Repositories\Contracts\TagInterface;


/**
 * Class TagService
 *
 * @package App\Services
 */
class TagService
{
    protected $tag;

    /**
     * TagService constructor.
     *
     * @param TagInterface $tag
     */
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvIndex()
    {
        $tags = $this->tag->getAll();
//        dd($tags);

        return $tags;
    }
}