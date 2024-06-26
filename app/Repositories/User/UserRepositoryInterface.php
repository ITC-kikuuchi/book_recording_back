<?php

declare(strict_types=1);

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * ユーザ情報取得
     *
     * @param integer $id
     * @return object|null
     */
    public function getUser(int $id): object|null;
}
