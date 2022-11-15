<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface ICategoryRepository extends IBaseRepository
{
    public function getPermissionRoots();

    public function getSelectRecursivePermissions($parent_id);
}
