<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\PathConst;
use App\Models\Book;
use App\Repositories\Book\BookRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class BookService
{
    use ExceptionHandlerTrait;

    /**
     * BookService コンストラクタ
     * BookRepositoryInterface の依存性を注入する
     *
     * @param BookRepositoryInterface $bookRepositoryInterface
     */
    public function __construct(protected BookRepositoryInterface $bookRepositoryInterface)
    {
    }

    /**
     * 書籍一覧取得
     *
     * @return JsonResponse
     */
    public function getBooks(): JsonResponse
    {
        // 初期値設定
        $responseData = [];
        try {
            // 書籍一覧取得
            $books = $this->bookRepositoryInterface->getBooks();
            // レスポンスデータの作成
            foreach ($books as $book) {
                $responseData[] = [
                    Book::ID => $book[Book::ID],
                    Book::TITLE => $book[Book::TITLE],
                    Book::AUTHOR => $book[Book::AUTHOR],
                    Book::GENRE => $book[Book::GENRE],
                    Book::COVER_IMAGE => $book[Book::COVER_IMAGE] ? asset(PathConst::PUBLIC_BOOK_PATH . '/' . $book[Book::COVER_IMAGE]) : null,
                ];
            }
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse($responseData);
    }
}
