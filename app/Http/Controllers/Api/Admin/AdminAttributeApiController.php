<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IAttributeRepository;
use App\Traits\ApiResponse;
use Exception;

class AdminAttributeApiController extends Controller
{
    use ApiResponse;

    private $attributeRepo;

    public function __construct(IAttributeRepository $attributeRepo)
    {
        $this->attributeRepo = $attributeRepo;
    }

    public function getApiAttribute()
    {
        try {
            $attributes = $this->attributeRepo->getAll();
            return $this->successResponse($attributes, "Get Attribute Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function findApiAttributeValueByAttributeId($id)
    {

        try {
            $attribute = $this->attributeRepo->findDataById($id);
            $attribute_value = $attribute->values;
            return $this->successResponse($attribute_value, "Get Attribute Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

    }
}
