<?php

declare(strict_types=1);

namespace App\Repositories\Memo;

use App\Models\Memo;

class MemoEloquentRepository implements MemoRepositoryInterface
{
    /**
     * MemoEloquentRepository コンストラクタ
     * Memo の依存性を注入する
     *
     * @param Memo $memo
     */
    public function __construct(protected Memo $memo)
    {
    }

    /**
     * メモ一覧取得
     *
     * @param integer $bookId
     * @return object|null
     */
    public function getMemos(int $bookId): object|null
    {
        return $this->memo->where(Memo::BOOK_ID, $bookId)->get();
    }
}
