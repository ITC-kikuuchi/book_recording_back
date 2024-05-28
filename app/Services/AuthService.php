<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    use ExceptionHandlerTrait;

    /**
     * AuthService コンストラクタ
     * UserRepositoryInterface の依存性を注入する
     *
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(protected UserRepositoryInterface $userRepositoryInterface)
    {
    }
}
