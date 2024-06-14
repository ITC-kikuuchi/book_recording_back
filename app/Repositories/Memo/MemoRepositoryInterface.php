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
}
