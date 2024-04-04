<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository
 */
class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all data
     *
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * Find related record by value
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function findBy($key, $value)
    {
        return $this->model->where($key, $value)->first();
    }

    /**
     * Get total records count
     *
     * @return mixed
     */
    public function total()
    {
        return $this->model->count();
    }

    /**
     * @param $data
     * @return string
     *
     * Insert a new record
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $item = $this->model->create($data);

            DB::commit();

            return $item;
        } catch (Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }

    }

    /**
     * @param $id
     * @param $data
     * @return string
     */
    public function update($id, $data)
    {
        try {
            DB::beginTransaction();

            $patient = $this->model->where('id', $id)->first();
            $patient->update($data);

            DB::commit();

            return $patient;
        } catch (Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /**
     * @param $key
     * @param $value
     * @return string|true
     */
    public function delete($key, $value)
    {
        try {
            DB::beginTransaction();

            $this->model->where($key, $value)->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function firstOrCreate($key, $data)
    {
        return $this->model->firstOrCreate([$key => $data[$key]], $data);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function exists($key, $value)
    {
        return $this->model->where($key, $value)->exists();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $count
     * @return mixed
     */
    public function paginate($count = 5)
    {
        return $this->model->paginate($count);
    }
}
