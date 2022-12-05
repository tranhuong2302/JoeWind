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

    public function getCategoryRoots()
    {
        return $this->category->where('parent_id', 0)->get();
    }

    public function getSelectRecursiveCategory($parent_id)
    {
        $data = $this->category->all();
        $recursive = new Recursive($data, '', '');
        return $recursive->dataSelectRecursive($parent_id);
    }

    public function getMultiSelectRecursiveCategory($catsId)
    {
        $data = $this->category->all();
        $recursive = new Recursive($data, '', '');
        return $recursive->dataMultiSelectRecursive($catsId);
    }

    public function getDataTableRecursiveCategories()
    {
        $data = $this->category->all();
        $recursive = new Recursive($data, 'categories', 'category');
        return $recursive->dataTableRecursive();
    }

    public function getApiCategoriesRecursive()
    {
        return $this->category->tree();
    }

    public function checkUpdateCategoryToChild($categoryChild_id, $category_id)
    {
        $category = $this->category->find($categoryChild_id);
        if ($category != null && $category->parent_id == $category_id) return true;
        else return false;
    }

    public function checkUpdateCategoryToItSelf($categorySelf_id, $category_id)
    {
        $category = $this->category->find($categorySelf_id);
        if ($category != null && $category->id == $category_id) return true;
        else return false;
    }

}
