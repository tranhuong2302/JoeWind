<?php

namespace App\Traits;

trait ApiResponse {

    public function successResponse($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'SUCCESS',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message = null, $code = 500)
    {
        return response()->json([
            'status' => 'FAIL',
            'message' => $message,
            'data' => null
        ], $code);
    }
}
