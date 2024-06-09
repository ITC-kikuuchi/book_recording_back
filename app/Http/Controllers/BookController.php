<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookRequest;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * BookController コンストラクタ
     * BookService の依存性を注入する
     *
     * @param BookService $bookService
     */
    public function __construct(protected BookService $bookService)
    {
    }

    /**
     * 書籍一覧取得API
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->bookService->getBooks();
    }

    /**
     * 書籍登録API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        return $this->bookService->createBook($request);
    }

    /**
     * 書籍詳細取得API
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->bookService->getBookDetail($id);
    }

    /**
     * 書籍更新API
     *
     * @param BookRequest $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(BookRequest $request, int $id): JsonResponse
    {
        return $this->bookService->updateBook($request, $id);
    }

    /**
     * 書籍削除API
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->bookService->deleteBook($id);
    }
}
