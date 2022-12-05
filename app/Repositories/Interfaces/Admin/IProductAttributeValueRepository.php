<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface IProductAttributeValueRepository extends IBaseRepository
{
    public function getAttributeValueByProductId($productId);

    public function findProductAttributeValueById($productId, $productAttributeValueId);

    public function updateProductAttributeValue($productId, $productAttributeValueId, $attributes = []);
}
