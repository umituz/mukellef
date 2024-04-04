<?php

namespace App\Repositories;

/**
 * Interface BaseRepositoryInterface
 */
interface BaseRepositoryInterface
{
    /**
     * Get all data
     *
     * @return mixed
     */
    public function get();

    /**
     * @param $key
     * @param $value
     * @return mixed
     *
     * Find by value
     */
    public function findBy($key, $value);

    /**
     * Get total record of table
     */
    public function total();

    /**
     * @param $data
     * @return string
     *
     * Insert a new record
     */
    public function create($data);

    /**
     * @param $id
     * @param $data
     * @return string
     * Update specific record
     */
    public function update($id, $data);

    /**
     * @param $key
     * @param $value
     * @return string|true
     *
     * Delete specific record
     */
    public function delete($key, $value);

    /**
     * @param $key
     * @param $data
     * @return mixed
     * Get specific data if not exists create
     */
    public function firstOrCreate($key, $data);

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function exists($key, $value);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $count
     * @return mixed
     */
    public function paginate($count = 5);
}
