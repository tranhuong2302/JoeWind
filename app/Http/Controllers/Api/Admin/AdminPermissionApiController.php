<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Traits\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class AdminPermissionApiController extends Controller
{
    use ApiResponse;

    private $permissionRepo;

    public function __construct(IPermissionRepository $permissionRepository)
    {
        $this->permissionRepo = $permissionRepository;
    }

    public function getApiPermissions()
    {
        try {
            $permissions = $this->permissionRepo->getAll();
            return $this->successResponse($permissions, "Get permission success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deletePermissionById($id)
    {
        try {
            $this->permissionRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete permission success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $this->permissionRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected permissions success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
