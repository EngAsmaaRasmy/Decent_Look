<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{

    public function apiResponse($data, string $message = null, int $status = 200)
    {

        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function errorrapiResponse(string $message = null, $data = null)
    {
        return response()->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ]);
    }
}
