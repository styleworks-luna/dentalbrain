<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inquiry_id')->comment('문의 일련번호');
            $table->string('display_name')->nullable()->default(null)->comment('표기 이름');
            $table->string('title')->comment('문의 답변 제목');
            $table->text('content')->comment('문의 답변 내용');
            $table->unsignedBigInteger('user_id')->comment('사용자 일련번호');

            $table->foreign('inquiry_id')->references('id')->on('inquiries');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::table('inquiry_answers', function (Blueprint $table) {
            $table->dropForeign('inquiry_answers_user_id_foreign');
            $table->dropForeign('inquiry_answers_inquiry_id_foreign');
        });
        Schema::dropIfExists('inquiry_answers');
    }
}
