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
     * @param int $count
     * @param array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function paginate(int $count, array $relations = [])
    {
        $instance = $this->getNewInstance();
        $instance = $instance->with($relations)->paginate($count);

        $instance->paginate_links = $instance->links();

        return $instance;
    }

    /**
     * @param integer $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById(int $id, array $relations = [])
    {
        $instance = $this->getNewInstance();

        return $instance->with($relations)->find($id);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBy(string $field, $value)
    {
        $instance = $this->getNewInstance();

        return $instance->where($field, $value)->get();
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $user = $this->getById($id);

        $user->update($data);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function store(array $data)
    {
        $model = $this->getNewInstance()->create($data);

        return $model;
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