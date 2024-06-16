<?php

namespace App\Http\Controllers;

use App\Services\MemoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * MemoController コンストラクタ
     * MemoService の依存性を注入する
     *
     * @param MemoService $memoService
     */
    public function __construct(protected MemoService $memoService)
    {
    }

    /**
     * メモ一覧取得API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->memoService->getMemos($request);
    }

    /**
     * メモ登録処理
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->memoService->createMemo($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
