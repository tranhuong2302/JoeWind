<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Role;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IRoleRepository;

class EloquentRoleRepository extends EloquentBaseRepository implements IRoleRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}
