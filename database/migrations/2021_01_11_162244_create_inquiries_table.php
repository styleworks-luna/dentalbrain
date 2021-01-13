<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('이름');
            $table->string('phone')->comment('전화번호');
            $table->string('email')->comment('email');
            $table->string('title')->comment('제목');
            $table->text('content')->comment('내용');
            $table->tinyInteger('category')->default(1)->comment('문의 내역 구분');
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
        Schema::dropIfExists('inquiries');
    }
}
