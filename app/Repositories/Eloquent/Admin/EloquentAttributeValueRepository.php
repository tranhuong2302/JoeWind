<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\AttributeValue;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IAttributeValueRepository;

class EloquentAttributeValueRepository extends EloquentBaseRepository implements IAttributeValueRepository
{
    private AttributeValue $attribute_values;

    public function __construct(AttributeValue $attribute_values)
    {
        parent::__construct($attribute_values);
        $this->attribute_values = $attribute_values;
    }

    public function getAttributeValueByAttributeId($attributeID)
    {
        return $this->attribute_values->where('attribute_id', $attributeID)->get();
    }
}
