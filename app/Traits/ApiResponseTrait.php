<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponseTrait
{

    protected function successResponse($data, $message = null, $code = 200){
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    protected function errorResponse($message, $code = 400){
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message,
            'data' => null,
        ], $code);
    }
    protected function validateErrorResponse($message, $code = 400){
        return response()->json([
            'success' => false,
            'status' => 'validation error',
            'message' => $message,
            'data' => null,
        ], $code);
    }
    protected function unauthorizedResponse($message){
        return response()->json([
            'success' => false,
            'status' => 'unauthorized',
            'message' => $message,
            'data' => null,
        ], 401);
    }
    protected function notFoundResponse($data = ''){
        return response()->json([
            'success' => false,
            'status' => 'not_found',
            'message' => 'Data '.$data.' not found !',
            'data' => null,
        ], 404);
    }
}
