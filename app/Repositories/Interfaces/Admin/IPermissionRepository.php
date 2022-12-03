<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface IPermissionRepository extends IBaseRepository
{
    public function getPermissionRoots();

    public function getSelectRecursivePermissions($parent_id);

    public function checkUpdatePermissionToChild($permissionChild_id, $permission_id);

    public function checkUpdatePermissionToItSelf($permissionSelf_id, $permission_id);

}
