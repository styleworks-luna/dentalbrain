<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateCompletionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_completions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('제목');
            $table->string('content')->comment('본문');
            $table->string('bottom_content')->comment('하단 내용');
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
        Schema::dropIfExists('certificate_completions');
    }
}
