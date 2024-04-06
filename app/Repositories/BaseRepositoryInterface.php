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
     * @return string
     *
     * Insert a new record
     */
    public function create($data);

    /**
     * @return string
     *                Update specific record
     */
    public function update($id, $data);

    /**
     * @return string|true
     *
     * Delete specific record
     */
    public function delete($key, $value);

    /**
     * @return mixed
     *               Get specific data if not exists create
     */
    public function firstOrCreate($key, $data);

    /**
     * @return mixed
     */
    public function exists($key, $value);

    /**
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function paginate($count = 5);
}
