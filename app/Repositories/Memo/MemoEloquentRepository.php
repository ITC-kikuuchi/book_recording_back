<?php

declare(strict_types=1);

namespace App\Repositories\Memo;

use App\Models\Memo;

class MemoEloquentRepository implements MemoRepositoryInterface
{
    /**
     * MemoEloquentRepository コンストラクタ
     * Memo の依存性を注入する
     *
     * @param Memo $memo
     */
    public function __construct(protected Memo $memo)
    {
    }

    /**
     * メモ一覧取得
     *
     * @param integer $bookId
     * @return object|null
     */
    public function getMemos(int $bookId): object|null
    {
        return $this->memo->where(Memo::BOOK_ID, $bookId)->get();
    }

    /**
     * メモ登録処理
     *
     * @param array $memoData
     */
    public function createMemo(array $memoData)
    {
        $this->memo->insert($memoData);
    }

    /**
     * メモ詳細取得処理
     *
     * @param integer $id
     * @return object|null
     */
    public function getMemoDetail(int $id): object|null
    {
        return $this->memo->find($id);
    }

    /**
     * メモ更新処理
     *
     * @param array $memoData
     */
    public function updateMemo(array $memoData)
    {
        foreach ($memoData as $value) {
            $this->memo->where(Memo::ID, $value[Memo::ID])->update($value[Memo::UPDATE_DATA]);
        }
    }

    /**
     * メモ削除処理
     *
     * @param int $id
     */
    public function deleteMemo(int $id)
    {
        $this->memo->destroy($id);
    }
}
