<?php

declare(strict_types=1);

namespace App\Repositories\Memo;

interface MemoRepositoryInterface
{
    /**
     * メモ一覧取得
     *
     * @param integer $bookId
     * @return object|null
     */
    public function getMemos(int $bookId): object|null;

    /**
     * メモ登録処理
     *
     * @param array $memoData
     */
    public function createMemo(array $memoData);

    /**
     * メモ詳細取得処理
     *
     * @param integer $id
     * @return object|null
     */
    public function getMemoDetail(int $id): object|null;

    /**
     * メモ更新処理
     *
     * @param array $memoData
     */
    public function updateMemo(array $memoData);
}
