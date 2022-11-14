<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface IPermissionRepository extends IBaseRepository
{
    public function getPermissionRoots();

    public function getSelectRecursivePermissions($parent_id);
}
