<?php

namespace App\Repositories\Eloquent\User;

use App\Models\Category;
use App\Repositories\Interfaces\User\IHomeRepository;

class EloquentHomeRepository implements IHomeRepository
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategoryRootFeatures()
    {
        return $this->category->where([
            ['parent_id', '=', 0],
            ['is_feature', '=', 1],
            ['status', '=', 1],
        ])->get();
    }
}
