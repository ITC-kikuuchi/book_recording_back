<?php

namespace App\Http\Controllers;

use App\Services\MemoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * MemoController コンストラクタ
     * MemoService の依存性を注入する
     *
     * @param MemoService $memoService
     */
    public function __construct(protected MemoService $memoService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
