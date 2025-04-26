<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Responses {

    public function generalResponse(bool $success, string $message, mixed $data, int $status = 200) : JsonResponse {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
