<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\PathConst;
use App\Models\Book;
use App\Repositories\Book\BookRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * ディレクトリの有無チェック、ディレクトリの作成、画像ファイルのアップロード
     *
     * @param object $imageFile
     * @return string
     */
    public function checkAndUploadFile(object $imageFile): string
    {
        if (!file_exists(PathConst::PUBLIC_BOOK_PATH)) {
            // ディレクトリが存在しない場合
            mkdir(PathConst::PUBLIC_BOOK_PATH);
        }
        // 画像ファイルアップロード
        $fileName = str_replace(PathConst::SAVE_BOOK_PATH . '/', '', $imageFile->storeAs(PathConst::SAVE_BOOK_PATH, $imageFile->getClientOriginalName()));
        if ($imageFile->isValid()) {
            // 画像アップロードに成功した場合
            return $fileName;
        } else {
            // 画像アップロードに失敗した場合
            throw new Exception();
        }
        // 保存した画像のパスの返却
        return $fileName;
    }
}
