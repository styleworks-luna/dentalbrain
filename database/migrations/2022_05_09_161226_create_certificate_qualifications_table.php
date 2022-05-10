<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('제목');
            $table->bigInteger('certification_number')->comment('자격번호');
            $table->string('grade')->comment('자격등급');
            $table->string('content')->comment('본문');
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
        Schema::dropIfExists('certificate_qualifications');
    }
}
