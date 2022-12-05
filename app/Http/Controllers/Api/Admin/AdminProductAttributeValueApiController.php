<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IProductAttributeValueRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class AdminProductAttributeValueApiController extends Controller
{
    use ApiResponse;

    private IProductAttributeValueRepository $productAttributeValueRepo;

    public function __construct(IProductAttributeValueRepository $productAttributeValueRepo)
    {
        $this->productAttributeValueRepo = $productAttributeValueRepo;
    }

    public function getApiProductAttributeValue($id)
    {
        try {
            $attributeValues = $this->productAttributeValueRepo->getAttributeValueByProductId($id);
            return $this->successResponse($attributeValues, "Get Attribute Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function findProductAttributeValueById($productId, $id)
    {
        try {
            $attributeValues = $this->productAttributeValueRepo->findProductAttributeValueById($productId, $id);
            return $this->successResponse($attributeValues, "Get Attribute Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $productId, $id)
    {
        try {
            $data = [
                'plus_price' => $request->input('plus_price'),
                'quantity' => $request->input('quantity'),
            ];
            $attributeValues = $this->productAttributeValueRepo->updateProductAttributeValue($productId, $id, $data);
            return $this->successResponse($attributeValues, "Get Attribute Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
