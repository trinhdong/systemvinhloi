<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepository
{
    //model want to interact
    protected $model;

    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get all record
     *
     * @param
     *
     * @return Model instance
     */
    public function getAll()
    {
        try {
            return $this->model->all();
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get record by conditions
     *
     * @param
     *
     * @return Model instance
     */
    public function getWhere($conditions = false)
    {
        if($conditions) {
            return $this->model->where($conditions)->get();
        }
        return $this->model->get();
    }

    /**
     * Get record by array conditions
     *
     * @param
     *
     * @return Model instance
     */
    public function getWherein($column, $value)
    {
        if($conditions) {
            return $this->model->whereIn($column, $value)->get();
        }
        return $this->model->get();
    }

    /**
     * Get multiple record by ids
     *
     * @param
     *
     * @return Model instance
     */
    public function getMultiple($ids)
    {
        return $this->model->whereIn('id',$ids)->get();
    }

    /**
     * Get record by like clause
     *
     * @param
     *
     * @return Model instance
     */
    public function getLike($column, $value)
    {
        return $this->getWhere([[$column,'LIKE','%'.$value.'%']]);
    }

    /**
     * Function paginate: Get record like conditions $filters. Return data as pagination
     * @param $filters
     */
    public function paginate($filters = [], $order_by = '' ,$sort = 'ASC', $limit = 20, $with = false)
    {
        try {
            $model = $this->model;
            $deleted = false;
            // relationship
            if ($with) {
                $model = $model->with($with);
            }

            // query condition
            if (!empty($filters)) {
                foreach ($filters as $key => $value) {
                    switch ($key) {
                        case 'select':
                            $model = $model->selectRaw($value);
                            break;

                        case 'sort':
                            $column = 'id';
                            if (is_array($value)) {
                                $column = $value['column'];
                                $value = $value['value'];
                            }

                            $model = $model->orderBy($column, $value);
                            break;

                        case 'join':
                            foreach($value as $key_value => $value_item){
                                $model = $model->join($value_item['table'], $value_item['table_id'], $value_item['table_reference_id']);
                            }
                            break;

                        case 'whereRaw':
                            $model = $model->whereRaw($value);
                            break;

                        case 'orderByRaw':
                            $model = $model->orderByRaw($value);
                            break;

                        case 'groupBy':
                            if(is_array($value)){
                                foreach($value as $key_value => $value_item){
                                    $model = $model->groupBy($value_item);
                                }
                                break;
                            }

                            $model = $model->groupBy($value);
                            break;

                        case 'deleted':
                            $deleted = true;
                            break;

                        default:
                            $logicalOperator = $value['logical_operator'] ?? 'AND';
                            if (is_array($value)) {
                                $operator = $value['operator'];
                                $value = $value['value'];
                            } else {
                                $operator = '=';
                            }

                            if ($operator == 'NOT IN') {
                                $whereNotInConditions[] = [$key, $value];
                                break;
                            }

                            if ($logicalOperator === 'OR') {
                                $orConditions[] = [$key, $operator, $value];
                            } else {
                                $andConditions[] = [$key, $operator, $value];
                            }

                    }
                }

                if (!empty($orConditions)) {
                    $model = $model->where(function ($query) use ($orConditions) {
                        foreach ($orConditions as $condition) {
                            $query->orWhere(...$condition);
                        }
                    });
                }

                if (!empty($andConditions)) {
                    foreach ($andConditions as $condition) {
                        $model = $model->where(...$condition);
                    }
                }
                if (!empty($whereNotInConditions)) {
                    foreach ($whereNotInConditions as $condition) {
                        $model = $model->whereNotIn(...$condition);
                    }
                }
            }

            // sort
            if ($order_by !== '') {
                $model = $model->orderBy($order_by, $sort);
            }

            if($deleted) {
                return $model->withTrashed()->paginate($limit);
            }

            return $model->paginate($limit);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Function filter: Get record where clause $filter and clause relationship $with
     * @param $filters, $with
     */
    public function filter($filters = false, $with = false)
    {
        try {
            $model = $this->model;
            $get = $first = $sql = false;

            // relationship
            if (!empty($with) && $with !== '') $model = $model->with($with);

            if (!empty($filters) && $filters !== '') {
                foreach ($filters as $key => $value) {
                    switch ($key) {
                        case 'select':
                            $model = $model->selectRaw($value);
                            break;

                        case 'sort':
                            $column = 'id';
                            if (is_array($value)) {
                                $column = $value['column'];
                                $value = $value['value'];
                            }

                            $model = $model->orderBy($column, $value);
                            break;

                        case 'get':
                            $get = true;
                            break;

                        case 'first':
                            $first = true;
                            break;

                        case 'sql':
                            $sql = true;
                            break;

                        case 'join':
                            foreach($value as $key_value => $value_item){
                                $model = $model->join($value_item['table'], $value_item['table_id'], $value_item['table_reference_id']);
                            }
                            break;

                        case 'whereRaw':
                            $model = $model->whereRaw($value);
                            break;

                        case 'groupBy':
                            if(is_array($value)){
                                foreach($value as $key_value => $value_item){
                                    $model = $model->groupBy($value_item);
                                }
                                break;
                            }

                            $model = $model->groupBy($value);
                            break;

                        case 'orderByRaw':
                            if(is_array($value)) {
                                $orderByColumn = $value['column'];
                                $orderByDirection = $value['direction'];
                                $model = $model->orderByRaw("$orderByColumn $orderByDirection");
                            } else {
                                $model = $model->orderByRaw($value);
                            }
                            break;

                        default:
                            if (is_array($value)) {
                                $operator = $value['operator'];
                                $value = $value['value'];
                            } else {
                                $operator = '=';
                            }

                            $model = $model->where($key, $operator, $value);
                            break;
                    }
                }
            }

            if ($get) return $model->get();

            if ($first) return $model->first();

            if ($sql) return $model->toSql();

            return $model->get();
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Get record by id
     *
     * @param
     *
     * @return Model instance
     */
    public function find($id)
    {
        try {
            $result = $this->model->find($id);
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Create record
     *
     * @param
     *
     * @return Model instance
     */
    public function create($attributes = [])
    {
        DB::beginTransaction();
        try {
            $attributes['created_by'] = Auth::user()->id;
            $result = $this->model->create($attributes);
            DB::commit();
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return false;
        }
    }

    /**
     * Insert data to DB
     *
     * @param
     *
     * @return Model instance
     */
    public function insert($p_obj)
    {
       foreach ($p_obj as $key => $value) {
           $this->model->$key = $value;
       }
	   $rs = false;
       try{
           $rs = $this->model->save();
       }catch(\Illuminate\Database\QueryException $e){
            $rs = false;
            dd($e);
       }
       if($rs == false)
        return false;
       return $this->model->id;
    }

    /**
     * update data by id
     *
     * @param
     *
     * @return Model instance
     */
    public function update($id, $attributes = [])
    {
        DB::beginTransaction();
        try {
            $result = $this->model->find($id);
            if ($result) {
                $attributes['updated_by'] = Auth::user()->id;
                $result->update($attributes);
                DB::commit();
                return $result;
            }
            DB::rollBack();

            return false;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return false;
        }
    }

    /**
     * update data by value conditions
     *
     * @param
     *
     * @return Model instance
     */
    public function updateByWhere($p_where, array $p_inputs)
    {
       $p_inputs['updated_by'] = Auth::user()->id;
       return $this->model->where($p_where)->update($p_inputs);
    }

    /**
     * update or insert data by value conditions
     *
     * @param
     *
     * @return Model instance
     */
    public function updateOrInsertData(array $attributes, array $values = [])
    {
       return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * delete record by id
     *
     * @param
     *
     * @return Model instance
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->find($id);
            if ($result) {
                $result->delete();
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return false;
        }
    }

    /**
     * delete record by conditions
     *
     * @param
     *
     * @return Model instance
     */
    public function destroyByWhere($p_arr)
    {
       return $this->model->where($p_arr)->delete();
    }

    public function getList($value = 'name')
    {
        return $this->model->pluck($value, 'id');
    }


    public function get()
    {
        return $this->model->get();
    }
}
