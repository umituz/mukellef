<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @return string
     *
     * Insert a new record
     *
     * @throws Exception
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

            throw $e;
        }
    }

    /**
     * @return string
     *
     * @throws Exception
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

            throw $e;
        }
    }

    /**
     * @return string|true
     *
     * @throws Exception
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

            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function firstOrCreate($key, $data)
    {
        return $this->model->firstOrCreate([$key => $data[$key]], $data);
    }

    /**
     * @return mixed
     */
    public function exists($key, $value)
    {
        return $this->model->where($key, $value)->exists();
    }

    /**
     * @return mixed
     */
    public function find($id)
    {
        $record = $this->model->find($id);

        if (! $record) {
            throw new ModelNotFoundException();
        }

        return $record;
    }

    /**
     * @return mixed
     */
    public function paginate($count = 5)
    {
        return $this->model->paginate($count);
    }
}
