<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Memo;
use App\Repositories\Memo\MemoRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemoService
{
    use ExceptionHandlerTrait;

    /**
     * MemoService コンストラクタ
     * MemoRepositoryInterface の依存性を注入する
     *
     * @param MemoRepositoryInterface $memoRepositoryInterface
     */
    public function __construct(protected MemoRepositoryInterface $memoRepositoryInterface)
    {
    }

    /**
     * メモ一覧取得処理
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMemos(Request $request): JsonResponse
    {
        // レスポンスデータ初期化
        $responseData = [];
        try {
            // id に紐づくメモの一覧取得
            $memos = $this->memoRepositoryInterface->getMemos($request[Memo::BOOK_ID]);
            // レスポンスデータの作成
            foreach ($memos as $memo) {
                $responseData[] = [
                    Memo::PAGE_NUMBER => $memo[Memo::PAGE_NUMBER],
                    Memo::MEMO => $memo[Memo::MEMO],
                ];
            }
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse($responseData);
    }
}
