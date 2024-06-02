<?php

declare(strict_types=1);

namespace App\Repositories\Book;

interface BookRepositoryInterface
{
    /**
     * 書籍一覧取得
     *
     * @return object|null
     */
    public function getBooks(): object|null;
}
