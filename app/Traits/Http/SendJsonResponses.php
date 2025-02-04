<?php

namespace App\Traits\Http;

use Illuminate\Http\Response;

trait SendJsonResponses
{
    private function sendResponse(array $data, int $statusCode = 200, array $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    private function sendNotFoundResponse(string $message, array $headers = [])
    {
        return $this->sendResponse([
            'success' => false,
            'message' => $message,
        ], Response::HTTP_NOT_FOUND, $headers);
    }

    private function sendBadRequestResponse(string $message, array $errors = [], array $headers = [])
    {
        return $this->sendResponse([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], Response::HTTP_BAD_REQUEST, $headers);
    }

    private function sendErrorResponse(string $message = 'Internal Server Error', array $headers = [])
    {
        return $this->sendResponse([
            'success' => false,
            'message' => $message,
        ], Response::HTTP_INTERNAL_SERVER_ERROR, $headers);
    }
}
