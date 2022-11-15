<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\ICategoryRepository;
use App\Traits\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryApiController extends Controller
{
    use ApiResponse;

    private $categoryRepo;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    public function getApiCategories()
    {
        try {
            $permissions = $this->categoryRepo->getAll();
            return $this->successResponse($permissions, "Get categories success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteCategoryById($id)
    {
        try {
            $this->categoryRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete category success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $this->categoryRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected category success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
