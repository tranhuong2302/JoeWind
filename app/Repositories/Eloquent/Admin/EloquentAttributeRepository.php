<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Attribute;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IAttributeRepository;

class EloquentAttributeRepository extends EloquentBaseRepository implements IAttributeRepository
{
    public function __construct(Attribute $attribute)
    {
        parent::__construct($attribute);
    }
}
