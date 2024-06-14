<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Memo;
use App\Repositories\Memo\MemoRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
