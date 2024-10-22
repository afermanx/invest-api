<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    /**
     * Return a created response.
     */
    public function created($data = []): JsonResponse
    {
        return Response::json($data, 201);
    }

    /**
     * Return an ok response.
     */
    public function ok($data = []): JsonResponse
    {
        return Response::json($data, 200);
    }

    /**
     * Return an no content response.
     */
    public function noContent($data = []): JsonResponse
    {
        return Response::json($data, 204);
    }

    /**
     * Return unauthorized response.
     */
    public function unauthorized(array $data = []): JsonResponse
    {
        return Response::json($data, 401);
    }

    /**
     * Return bad request response.
     */
    public function badRequest(array $data = []): JsonResponse
    {
        return Response::json($data, 400);
    }

    /**
     * Return not found response.
     */
    public function notFound(array $data = []): JsonResponse
    {
        return Response::json($data, 404);
    }

    /**
     * Return internal server error response.
     */
    public function internalServerError(array $data = []): JsonResponse
    {
        return Response::json($data, 500);
    }
}
