<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_memo', function (Blueprint $table) {
            $table->id()->comment('メモID');
            $table->integer('page_number')->nullable()->comment('ページ番号');
            $table->text('memo')->nullable()->comment('メモ');
            $table->unsignedBigInteger('book_id')->nullable(false)->comment('書籍ID');
            $table->foreign('book_id')->references('id')->on('t_book')->cascadeOnDelete();
            $table->integer('created_id')->nullable()->comment('登録者');
            $table->integer('updated_id')->nullable()->comment('更新者');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_memo');
    }
};
