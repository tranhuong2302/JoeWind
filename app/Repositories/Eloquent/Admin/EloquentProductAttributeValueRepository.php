<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\ProductAttributeValue;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IProductAttributeValueRepository;
use Illuminate\Support\Facades\DB;

class EloquentProductAttributeValueRepository extends EloquentBaseRepository implements IProductAttributeValueRepository
{
    private ProductAttributeValue $productAttributeValue;

    public function __construct(ProductAttributeValue $productAttributeValue)
    {
        parent::__construct($productAttributeValue);
        $this->productAttributeValue = $productAttributeValue;
    }

    public function getAttributeValueByProductId($productId)
    {
        return DB::table('product_attribute_values')->join('attribute_values', 'attribute_values.id', '=', 'product_attribute_values.attribute_value_id')->select('product_attribute_values.*', 'attribute_value_name')->where('product_id', $productId)->get();
    }

    public function findProductAttributeValueById($productId, $productAttributeValueId)
    {
        return DB::table('product_attribute_values')->join('attribute_values', 'attribute_values.id', '=', 'product_attribute_values.attribute_value_id')->select('product_attribute_values.*', 'attribute_value_name')->where([
            ['product_attribute_values.product_id', $productId],
            ['product_attribute_values.id', $productAttributeValueId]
        ])->first();
    }

    public function updateProductAttributeValue($productId, $productAttributeValueId, $attributes = [])
    {
        $attribute_values = $this->productAttributeValue->where([
            ['product_attribute_values.product_id', $productId],
            ['product_attribute_values.id', $productAttributeValueId]
        ])->first();
        if ($attribute_values) {
            $attribute_values->update($attributes);
            return $attribute_values;
        } else return false;
    }
}
