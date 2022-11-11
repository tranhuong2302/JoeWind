<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\AccountRepository;
use App\Traits\ApiResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class AdminAccountApiController extends Controller
{
    use ApiResponse;

    private $accountRepo;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepo = $accountRepository;
    }

    public function getApiAccount()
    {
        try {
            $accounts = $this->accountRepo->getAccounts();
            return $this->successResponse($accounts, "Get Account Success");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteAccountById($id)
    {
        try {
            $this->accountRepo->deleteAccountById($id);
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
            $this->accountRepo->deleteMultipleAccount($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected account success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
