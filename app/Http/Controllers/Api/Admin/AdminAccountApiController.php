<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IAccountRepository;
use App\Traits\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class AdminAccountApiController extends Controller
{
    use ApiResponse;

    private $accountRepo;

    public function __construct(IAccountRepository $accountRepository)
    {
        $this->accountRepo = $accountRepository;
    }

    public function getApiAccount()
    {
        try {
            $accounts = $this->accountRepo->getAll();
            return $this->successResponse($accounts, "Get Account Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteAccountById($id)
    {
        try {
            $this->accountRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete account success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $this->accountRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected account success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
