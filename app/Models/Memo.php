<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    // テーブ名
    const TABLE = 't_memo';
    public $table = self::TABLE;

    // カラム名
    const ID = 'id';
    const PAGE_NUMBER = 'page_number';
    const MEMO = 'memo';
    const BOOK_ID = 'book_id';
    const CREATED_ID = 'created_id';
    const UPDATED_ID = 'updated_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ID,
        self::PAGE_NUMBER,
        self::MEMO,
        self::BOOK_ID,
        self::CREATED_ID,
        self::UPDATED_ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
