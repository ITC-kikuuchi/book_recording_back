<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ログインAPI
Route::post('login', [AuthController::class, 'login']);

// ミドルウェア auth:sanctum を指定したグループ
Route::group(['middleware' => ['auth:sanctum']], function () {
});
