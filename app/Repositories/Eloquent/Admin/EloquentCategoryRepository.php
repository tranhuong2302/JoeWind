<?php

namespace App\Repositories\Eloquent\Admin;

use App\Helpers\Recursive;
use App\Models\Category;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\ICategoryRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements ICategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->category = $category;
    }

    public function getPermissionRoots()
    {
        return $this->category->where('parent_id', 0)->get();
    }

    public function getSelectRecursivePermissions($parent_id)
    {
        $data = $this->category->all();
        $recursive = new Recursive($data, '');
        return $recursive->dataSelectRecursive($parent_id);

    }

    public function getDataTableRecursivePermissions()
    {
        $data = $this->category->all();
        $recursive = new Recursive($data, 'categories');
        return $recursive->dataTableRecursive();
    }
}
