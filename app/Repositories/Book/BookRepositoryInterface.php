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

    /**
     * 書籍登録
     *
     * @param array $bookData
     */
    public function createBook(array $bookData);

    /**
     * 書籍詳細取得
     *
     * @param integer $bookId
     * @return object|null
     */
    public function getBookDetail(int $bookId): object|null;

    /**
     * 書籍更新処理
     *
     * @param int $id
     * @param array $bookData
     */
    public function updateBook(int $id, array $bookData);
}
