<?php

namespace App\Repositories\DB_MySQL;


/**
 * Class BaseRepository
 *
 * @package App\Repositories\DB_MySQL
 */
class BaseRepository
{
    protected $modelName;

    /**
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function getAll(array $relations = [])
    {
        return $this->getNewInstance()->with($relations)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    protected function getNewInstance()
    {
        $model = new $this->modelName;

        return $model;
    }
}