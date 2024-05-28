<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // テーブ名
    const TABLE = 't_book';
    public $table = self::TABLE;

    // カラム名
    const ID = 'id';
    const TITLE = 'title';
    const AUTHOR = 'author';
    const GENRE = 'genre';
    const PUBLICATION_YEAR = 'publication_year';
    const PUBLISHER = 'publisher';
    const ISBN = 'isbn';
    const COVER_IMAGE = 'cover_image';
    const NUMBER_OF_PAGES = 'number_of_pages';
    const USER_ID = 'user_id';
    const CREATED_ID = 'created_id';
    const UPDATED_ID = 'updated_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ID,
        self::TITLE,
        self::AUTHOR,
        self::GENRE,
        self::PUBLICATION_YEAR,
        self::PUBLISHER,
        self::ISBN,
        self::COVER_IMAGE,
        self::NUMBER_OF_PAGES,
        self::USER_ID,
        self::CREATED_ID,
        self::UPDATED_ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
