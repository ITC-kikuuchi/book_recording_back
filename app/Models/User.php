<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // テーブ名
    const TABLE = 'users';
    public $table = self::TABLE;

    // カラム名
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    const PASSWORD = 'password';
    const REMEMBER_TOKEN = 'remember_token';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ID,
        self::NAME,
        self::EMAIL,
        self::EMAIL_VERIFIED_AT,
        self::PASSWORD,
        self::REMEMBER_TOKEN,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
