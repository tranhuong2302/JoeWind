<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface ICategoryRepository extends IBaseRepository
{
    public function getCategoryRoots();

    public function getApiCategoriesRecursive();

    public function getSelectRecursiveCategory($parent_id);

    public function getMultiSelectRecursiveCategory($catsId);

    public function checkUpdateCategoryToChild($categoryChild_id, $category_id);

    public function checkUpdateCategoryToItSelf($categorySelf_id, $category_id);

}
