<?php

declare(strict_types=1);

namespace App\Repositories\Book;

use App\Models\Book;

class BookEloquentRepository implements BookRepositoryInterface
{
    /**
     * BookEloquentRepository コンストラクタ
     * Book の依存性を注入する
     *
     * @param Book $book
     */
    public function __construct(protected Book $book)
    {
    }

    /**
     * 書籍一覧取得
     *
     * @return object|null
     */
    public function getBooks(): object|null
    {
        return $this->book->get();
    }
}
