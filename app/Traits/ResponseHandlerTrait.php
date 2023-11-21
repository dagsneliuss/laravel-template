<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseHandlerTrait
{
    /**
     * Generate a successful response with the given data.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $statusCode
     * @return Response
     */
    public function successResponse($data = [], $message = null, $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message ?? 'Operation successful.',
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Generate an error response with the given message.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $statusCode = 400): \Illuminate\Http\JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }
}
