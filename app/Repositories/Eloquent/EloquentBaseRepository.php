<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\IBaseRepository;
use Illuminate\Database\Eloquent\Model;

class EloquentBaseRepository implements IBaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function createData(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function findDataById($id)
    {
        return $this->model->find($id);
    }

    public function updateDataById($id, array $attributes)
    {
        $data = $this->model->find($id);
        if ($data) {
            $data->update($attributes);
            return $data;
        }
        return false;
    }

    public function deleteDataById($id)
    {
        $data = $this->model->find($id);
        if ($data) {
            $data->delete();
            return true;
        }
        return false;
    }

    public function deleteMultipleData($ids)
    {
        $dataSelected = $this->model->whereIn('id', $ids);
        if ($dataSelected) {
            $dataSelected->delete();
            return true;
        }
        return false;
    }

}
