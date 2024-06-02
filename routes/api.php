<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ログインAPI
Route::post('login', [AuthController::class, 'login']);

// ログアウトAPI
Route::post('logout', [AuthController::class, 'logout']);

// ミドルウェア auth:sanctum を指定したグループ
Route::group(['middleware' => ['auth:sanctum']], function () {
    // ログイン情報取得API
    Route::get('me', [AuthController::class, 'me']);
    // 書籍API
    Route::apiResource('books', BookController::class, ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
});
