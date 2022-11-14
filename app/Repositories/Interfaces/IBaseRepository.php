<?php

namespace App\Repositories\Interfaces;

interface IBaseRepository
{
    public function getAll();

    public function createData(array $attributes);

    public function findDataById($id);

    public function updateDataById($id, array $attributes);

    public function deleteDataById($id);

    public function deleteMultipleData($ids);
}
