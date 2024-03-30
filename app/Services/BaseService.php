<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    //repository want to interact
    protected $repository;

    abstract public function getRepository();

    /**
     * Set repository
     */
    public function setRepository()
    {
        $this->repository = app()->make(
            $this->getRepository()
        );
    }

    /**
     * Function GetAll: Get all record.
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * Function paginate: Get record like conditions $filters. Return data as pagination
     */
    public function paginate($filters = [], $order_by = '' ,$sort = 'DESC', $limit = 20, $with = false){
        return $this->repository->paginate($filters, $order_by, $sort , $limit, $with);
    }

    /**
     * Function find: Get record by $id
     */
    public function find($id)
    {
        try {
            $result = $this->repository->find($id);
            return $result;

        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function filter: Get record where clause $filter and clause relationship $with
     */
    public function filter($filters = false, $with = false){
        try {
            $result = $this->repository->filter($filters, $with);
            return $result;

        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function create: Create record
     * @param $attributes
     */
    public function create($attributes = [])
    {
        try {
            $result = $this->repository->create($attributes);
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function update: Update data by id
     * @param $id, $attributes
     */
    public function update($id, $attributes = [])
    {
        try {
            $result = $this->repository->update($id, $attributes);
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function delete: Delete data by id
     * @param $id
     */
    public function delete($id)
    {
        try {
            $result = $this->repository->delete($id);
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function updateOrCreate: Update data or Create record
     * @param $attributes, $values
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        try {
            $result =$this->repository->updateOrInsertData($attributes, $values);
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
