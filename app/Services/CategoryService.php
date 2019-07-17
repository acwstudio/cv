<?php

namespace App\Services;
use App\Repositories\Contracts\CategoryInterface;


/**
 * Class CategoryService
 *
 * @package App\Services
 */
class CategoryService
{
    protected $category;

    /**
     * CategoryService constructor.
     *
     * @param CategoryInterface $category
     */
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function srvIndex()
    {
        $categories = $this->category->getAll();

        return $categories;
    }
}