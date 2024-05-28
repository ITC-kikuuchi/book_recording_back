<?php

declare(strict_types=1);

namespace App\Traits;

use App\Consts\HttpStatusConst;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * 成功時（200）レスポンス
     * @param array $responseData
     * @return JsonResponse
     */
    public function okResponse(array $responseData = []): JsonResponse
    {
        return response()->json($responseData, HttpStatusConst::OK);
    }

    /**
     * 401エラーレスポンス
     * @return JsonResponse
     */
    public function unauthorizedResponse(): JsonResponse
    {
        return response()->json([], HttpStatusConst::UNAUTHORIZED);
    }
}
