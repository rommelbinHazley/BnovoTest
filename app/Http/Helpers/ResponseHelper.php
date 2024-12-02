<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseHelper
{
    /**
     * Успешный ответ.
     *
     * @param  mixed  $result
     */
    public static function success($result = [], int $status = Response::HTTP_OK): JsonResponse
    {
        return static::handler([
            'data' => $result,
            'success' => true,
        ], $status);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function handler(array $data, int $status): JsonResponse
    {
        return response()->json(
            $data,
            $status,
            [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8',
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
