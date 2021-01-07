<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question')->comment('faq 질문 제목');
            $table->text('answer')->comment('질문 답변');
            $table->unsignedBigInteger('category_id')->comment('카테고리 FK');

            $table->foreign('category_id')->references('id')->on('faq_categories');

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
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropForeign('faqs_category_id_foreign');
        });

        Schema::dropIfExists('faqs');
    }
}
