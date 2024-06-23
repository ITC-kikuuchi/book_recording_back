<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Memo;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Memo\MemoRepositoryInterface;
use App\Traits\DataExistenceCheckTrait;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemoService
{
    use ExceptionHandlerTrait;
    use DataExistenceCheckTrait;

    /**
     * MemoService コンストラクタ
     * MemoRepositoryInterface の依存性を注入する
     *
     * @param MemoRepositoryInterface $memoRepositoryInterface
     */
    public function __construct(
        protected MemoRepositoryInterface $memoRepositoryInterface,
        protected BookRepositoryInterface $bookRepositoryInterface
    ) {
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

    /**
     * メモ登録処理
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createMemo(Request $request): JsonResponse
    {
        try {
            // 登録データの作成
            foreach ($request[Memo::MEMOS] as $value) {
                $memoData[] = [
                    Memo::PAGE_NUMBER => $value[Memo::PAGE_NUMBER],
                    Memo::MEMO => $value[Memo::MEMO],
                    Memo::BOOK_ID => $request[Memo::BOOK_ID]
                ];
            }
            // データベーストランザクションを開始
            DB::transaction(function () use ($memoData) {
                // データ登録処理
                $this->memoRepositoryInterface->createMemo($memoData);
            });
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }

    /**
     * メモ更新処理
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateMemo(Request $request, $id): JsonResponse
    {
        try {
            // データ存在チェック
            $this->dataExistenceCheck($this->bookRepositoryInterface->getBookDetail((int)$id));
            // 更新データの作成
            foreach ($request[Memo::MEMOS] as $value) {
                $memoData[] = [
                    Memo::ID => $value[Memo::ID],
                    Memo::UPDATE_DATA => [
                        Memo::PAGE_NUMBER => $value[Memo::PAGE_NUMBER],
                        Memo::MEMO => $value[Memo::MEMO],
                    ],
                ];
            }
            // データベーストランザクションを開始
            DB::transaction(function () use ($memoData) {
                // データ更新処理
                $this->memoRepositoryInterface->updateMemo($memoData);
            });
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }

    /**
     * メモ削除処理
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteMemo(int $id): JsonResponse
    {
        try {
            // データ存在チェック
            $this->dataExistenceCheck($this->memoRepositoryInterface->getMemoDetail($id));
            // データベーストランザクションを開始
            DB::transaction(function () use ($id) {
                // データ削除処理
                $this->memoRepositoryInterface->deleteMemo($id);
            });
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }
}
