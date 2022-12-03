<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IProductRepository;
use App\Traits\ApiResponse;
use Exception;

class AdminProductApiController extends Controller
{
    use ApiResponse;

    private $productRepo;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    public function getApiProducts()
    {
        try {
            $products = $this->productRepo->getProductAllWithOneImages();
            return $this->successResponse($products, "Get products success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
