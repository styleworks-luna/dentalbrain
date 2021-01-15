<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('공지사항 제목');
            $table->text('content')->comment('공지사항 내용');
            $table->string('display_name')->nullable()->comment('null 이면 "관리자" 출력');
            $table->unsignedBigInteger('views')->comment('조회수')->default('0');
            $table->unsignedBigInteger('user_id')->comment('작성자');
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('is_open')->default(1)->comment('공개 / 비공개');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notices', function (Blueprint $table) {
            $table->dropForeign('notices_user_id_foreign');
        });
        Schema::dropIfExists('notices');
    }
}
