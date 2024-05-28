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
        Schema::create('t_book', function (Blueprint $table) {
            $table->id()->comment('書籍ID');
            $table->string('title', 255)->comment('書籍名');
            $table->string('author', 255)->nullable()->comment('著者');
            $table->string('genre', 255)->nullable()->comment('ジャンル');
            $table->date('publication_year')->nullable()->comment('出版年');
            $table->string('publisher', 255)->nullable()->comment('出版社');
            $table->string('isbn', 255)->nullable()->comment('ISBN');
            $table->string('cover_Image', 255)->nullable()->comment('カバー画像');
            $table->integer('number_of_pages')->nullable()->comment('ページ数');
            $table->unsignedBigInteger('organizer_id')->nullable(false)->comment('ユーザID');
            $table->foreign('organizer_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('t_book');
    }
};
