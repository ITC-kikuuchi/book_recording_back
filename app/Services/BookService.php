<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\PathConst;
use App\Http\Requests\Book\BookRequest;
use App\Models\Book;
use App\Repositories\Book\BookRepositoryInterface;
use App\Traits\DataExistenceCheckTrait;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookService
{
    use ExceptionHandlerTrait;
    use DataExistenceCheckTrait;

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
     * 書籍登録処理
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function createBook(BookRequest $request): JsonResponse
    {
        try {
            // 登録データの作成
            $bookData = $this->createBookData($request);
            // データベーストランザクションを開始
            DB::transaction(function () use ($bookData) {
                // データ登録処理
                return $this->bookRepositoryInterface->createBook($bookData);
            });
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }

    /**
     * 書籍詳細取得
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getBookDetail(int $id): JsonResponse
    {
        // 初期値設定
        $responseData = [];
        try {
            // id に紐づく書籍データの取得
            $bookData = $this->bookRepositoryInterface->getBookDetail($id);
            // データ存在チェック
            $this->dataExistenceCheck($bookData);
            // レスポンスデータの作成
            $responseData = [
                Book::ID => $bookData[Book::ID],
                Book::TITLE => $bookData[Book::TITLE],
                Book::AUTHOR => $bookData[Book::AUTHOR],
                Book::GENRE => $bookData[Book::GENRE],
                Book::PUBLICATION_YEAR => $bookData[Book::PUBLICATION_YEAR],
                Book::PUBLISHER => $bookData[Book::PUBLISHER],
                Book::ISBN => $bookData[Book::ISBN],
                Book::COVER_IMAGE => $bookData[Book::COVER_IMAGE] ? asset(PathConst::PUBLIC_BOOK_PATH . '/' . $bookData[Book::COVER_IMAGE]) : null,
                Book::USER_ID => $bookData[Book::USER_ID],
            ];
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse($responseData);
    }

    /**
     * 書籍更新処理
     *
     * @param BookRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateBook(BookRequest $request, int $id): JsonResponse
    {
        try {
            // id に紐づく書籍情報の取得
            $book = $this->bookRepositoryInterface->getBookDetail($id);
            // データ存在チェック
            $this->dataExistenceCheck($book);
            // 画像削除処理
            if ($request[Book::COVER_IMAGE]) {
                // 画像ファイルがリクエストされている場合
                if ($book[Book::COVER_IMAGE] != $request[Book::COVER_IMAGE]->getClientOriginalName()) {
                    // 既存の画像ファイル名とリクエストされた画像ファイル名が異なる場合
                    // 既存の画像を削除
                    $this->checkAndDeleteFile($book[Book::COVER_IMAGE]);
                }
            } else if ($book[Book::COVER_IMAGE]) {
                // 画像ファイルがリクエストされておらず、既存の画像ファイルが存在する場合
                $this->checkAndDeleteFile($book[Book::COVER_IMAGE]);
            }
            // 更新データの作成
            $bookData = $this->createBookData($request);
            // データベーストランザクションを開始
            DB::transaction(function () use ($id, $bookData) {
                // データ更新処理
                $this->bookRepositoryInterface->updateBook($id, $bookData);
            });
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }

    /**
     * 書籍削除処理
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteBook(int $id): JsonResponse
    {
        try {
            // id に紐づく書籍情報の取得
            $book = $this->bookRepositoryInterface->getBookDetail($id);
            // データ存在チェック
            $this->dataExistenceCheck($book);
            // データベーストランザクションを開始
            DB::transaction(function () use ($id) {
                // データ削除処理
                $this->bookRepositoryInterface->deleteBook($id);
            });
            // 画像ファイル削除処理
            if ($book[Book::COVER_IMAGE]) {
                // 既存の画像ファイルが存在する場合
                $this->checkAndDeleteFile($book[Book::COVER_IMAGE]);
            }
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }

    /**
     * 登録データの作成
     *
     * @param object $request
     * @return array
     */
    public function createBookData(object $request): array
    {
        // 登録データの作成
        return [
            Book::TITLE => $request[Book::TITLE],
            Book::AUTHOR => $request[Book::AUTHOR],
            Book::GENRE => $request[Book::GENRE],
            Book::PUBLICATION_YEAR => $request[Book::PUBLICATION_YEAR],
            Book::PUBLISHER => $request[Book::PUBLISHER],
            Book::ISBN => $request[Book::ISBN],
            Book::COVER_IMAGE => $request[Book::COVER_IMAGE] ? $this->checkAndUploadFile($request[Book::COVER_IMAGE]) : null,
            Book::NUMBER_OF_PAGES => $request[Book::NUMBER_OF_PAGES],
            Book::USER_ID => $request[Book::USER_ID],
            Book::CREATED_ID => $request[Book::USER_ID],
            Book::UPDATED_ID => $request[Book::USER_ID],
        ];
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

    /**
     * 画像ファイルの有無チェック、画像ファイル削除
     *
     * @param string $imageUrl
     */
    private function checkAndDeleteFile(string $imageUrl)
    {
        // ファイルの有無をチェック
        if (file_exists(PathConst::PUBLIC_BOOK_PATH . '/' . $imageUrl)) {
            // ファイルが存在した場合
            // ファイルを削除するメソッドの呼び出し
            Storage::delete(PathConst::SAVE_BOOK_PATH . '/' . $imageUrl);
        }
    }
}
