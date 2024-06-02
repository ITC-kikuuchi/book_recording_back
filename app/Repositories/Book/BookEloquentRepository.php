<?php

declare(strict_types=1);

namespace App\Repositories\Book;

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
}
