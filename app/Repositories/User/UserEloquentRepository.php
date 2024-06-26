<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    /**
     * UserEloquentRepository コンストラクタ
     * User の依存性を注入する
     *
     * @param User $user
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * ユーザ情報取得
     *
     * @param integer $id
     * @return object|null
     */
    public function getUser(int $id): object|null
    {
        return $this->user->where(User::ID, $id)->first();
    }
}
