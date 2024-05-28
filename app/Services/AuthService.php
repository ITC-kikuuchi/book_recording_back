<?php

declare(strict_types=1);

namespace App\Services;

class AuthService
{
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
