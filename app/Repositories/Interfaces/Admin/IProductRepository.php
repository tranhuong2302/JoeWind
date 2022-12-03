<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface IProductRepository extends IBaseRepository
{
    public function getProductAllWithOneImages();

    public function getCategoryIdsByProductId($productId);
}
