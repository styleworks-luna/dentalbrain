<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->unsignedBigInteger('enquiry_id')->comment('문의 일련번호');
            $table->string('display_name')->nullable()->comment('표기 이름');
            $table->string('title')->comment('문의 답변 제목');
            $table->text('content')->comment('문의 답변 내용');
            $table->unsignedBigInteger('user_id')->comment('사용자 일련번호');

            $table->foreign('enquiry_id')->references('id')->on('inquiries');
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

        Schema::table('inquiry_answers',function (Blueprint $table) {
            $table->dropForeign('inquiry_answers_enquiry_id_foreign');
            $table->dropColumn('enquiry_id');

            $table->dropForeign('inquiry_answers_user_id_foreign');
            $table->dropColumn('user_id');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('inquiry_answers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
