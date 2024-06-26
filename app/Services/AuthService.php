<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    use ExceptionHandlerTrait;

    /**
     * AuthService コンストラクタ
     * UserRepositoryInterface の依存性を注入する
     *
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(protected UserRepositoryInterface $userRepositoryInterface)
    {
    }

    /**
     * ログイン処理
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // 初期値設定
        $responseData = [];
        try {
            // リクエスト値の抽出
            $credentials = $request->only([User::EMAIL, User::PASSWORD]);
            if (Auth::attempt($credentials)) {
                // ユーザ認証に成功した場合
                $request->session()->regenerate();
                // 認証ユーザの ID に紐づくユーザ情報の取得
                $loginUser = $this->userRepositoryInterface->getUser(Auth::id());
                // レスポンスデータの作成
                $responseData = $this->userResponse($loginUser);
            } else {
                // ユーザ認証に失敗した場合
                throw new UnauthorizedException();
            }
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse($responseData);
    }

    /**
     * ログイン情報取得
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        // 初期値設定
        $responseData = [];
        try {
            // 認証ユーザの ID に紐づくユーザ情報の取得
            $loginUser = $this->userRepositoryInterface->getUser(Auth::id());
            if (!$loginUser) {
                // ID に紐づくユーザ情報が存在しない場合
                throw new UnauthorizedException();
            }
            // レスポンスデータの作成
            $responseData = $this->userResponse($loginUser);
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse($responseData);
    }

    /**
     * ログアウト処理
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            // ログアウト処理
            Auth::logout();
        } catch (Exception $e) {
            // エラーハンドリング
            return $this->exceptionHandler($e);
        }
        // 200 レスポンス
        return $this->okResponse();
    }

    /**
     * ユーザに関するレスポンスの作成
     *
     * @param object $loginUser
     * @return array
     */
    private function userResponse(object $loginUser): array
    {
        return [
            User::ID => $loginUser->pluck(User::ID)->first(),
            User::NAME => $loginUser->pluck(User::NAME)->first(),
            User::EMAIL => $loginUser->pluck(User::EMAIL)->first(),
        ];
    }
}
