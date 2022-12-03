<?php

namespace App\Repositories\Eloquent\Admin;

use App\Helpers\Recursive;
use App\Models\Permission;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IPermissionRepository;

class EloquentPermissionRepository extends EloquentBaseRepository implements IPermissionRepository
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
        $this->permission = $permission;
    }

    public function getPermissionRoots()
    {
        return $this->permission->where('parent_id', 0)->get();
    }

    public function getSelectRecursivePermissions($parent_id)
    {
        $data = $this->permission->all();
        $recursive = new Recursive($data, '', '');
        return $recursive->dataSelectRecursive($parent_id);

    }

    public function getDataTableRecursivePermissions()
    {
        $data = $this->permission->all();
        $recursive = new Recursive($data, 'permissions', 'permission');
        return $recursive->dataTableRecursive();
    }

    public function checkUpdatePermissionToChild($permissionChild_id, $permission_id)
    {
        $permission = $this->permission->find($permissionChild_id);
        if ($permission != null && $permission->parent_id == $permission_id) return true;
        else return false;
    }

    public function checkUpdatePermissionToItSelf($permissionSelf_id, $permission_id)
    {
        $permission = $this->permission->find($permissionSelf_id);
        if ($permission != null && $permission->id == $permission_id) return true;
        else return false;
    }
}
