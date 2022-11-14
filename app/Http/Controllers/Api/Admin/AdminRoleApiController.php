<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IRoleRepository;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;
class AdminRoleApiController extends Controller
{
    use ApiResponse;

    private $roleRepo;

    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepo = $roleRepository;
    }

    public function getApiRoles()
    {
        try {
            $roles = $this->roleRepo->getAll();
            return $this->successResponse($roles, "Get roles success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteRoleById($id)
    {
        try {
            $this->roleRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete role success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $this->roleRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected role success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
