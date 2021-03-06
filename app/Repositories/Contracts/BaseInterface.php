<?php

namespace App\Repositories\Contracts;


/**
 * Interface BaseInterface
 *
 * @package App\Repositories\Contracts
 */
interface BaseInterface
{
    /**
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $relations = []);

    /**
     * @param int $count
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function paginate(int $count, array $relations = []);

    /**
     * @param integer $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getById(int $id, array $relations = []);

    /**
     * @param string $field
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBy(string $field, $value);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id);
}