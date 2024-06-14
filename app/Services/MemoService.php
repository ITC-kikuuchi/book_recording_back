<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Memo\MemoRepositoryInterface;
class MemoService
{
    /**
     * MemoService コンストラクタ
     * MemoRepositoryInterface の依存性を注入する
     *
     * @param MemoRepositoryInterface $memoRepositoryInterface
     */
    public function __construct(protected MemoRepositoryInterface $memoRepositoryInterface)
    {
    }
}
