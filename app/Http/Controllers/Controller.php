<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function successResponse(mixed $data = null, string $message = 'Opera??o realizada com sucesso.', int $statusCode = 200, string $status = 'success'): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse(string $message, mixed $data = null, int $statusCode = 400, string $status = 'error'): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function paginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ];
    }

    protected function deleteModel(callable $callback, string $successMessage, string $failureMessage = 'N?o ? poss?vel remover o registro porque ele est? em uso.'): JsonResponse
    {
        try {
            $callback();

            return $this->successResponse(null, $successMessage);
        } catch (QueryException $exception) {
            return $this->errorResponse($failureMessage, null, 409);
        }
    }
}
