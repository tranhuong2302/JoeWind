<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface IAttributeValueRepository extends IBaseRepository
{
    public function getAttributeValueByAttributeId($attributeID);
}
