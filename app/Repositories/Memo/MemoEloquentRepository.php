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
}
