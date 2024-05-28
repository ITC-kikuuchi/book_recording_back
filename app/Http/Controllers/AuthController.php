<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * AuthController コンストラクタ
     * AuthService の依存性を注入する
     *
     * @param AuthService $authService
     */
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * ログイン処理
     *
     * @param   LoginRequest $request
     * @return  JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }
}
