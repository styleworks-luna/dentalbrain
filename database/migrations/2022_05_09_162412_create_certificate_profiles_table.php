<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('사용자 일련번호');
            $table->unsignedBigInteger('program_id')->comment('강의 일련번호');
            $table->unsignedBigInteger('qualification_id')->nullable()->comment('자격증 일련번호');
            $table->unsignedBigInteger('completion_id')->nullable()->comment('수료증 일련번호');
            $table->unsignedBigInteger('file_id')->comment('파일 일련번호');
            $table->string('name')->comment('이름');
            $table->string('birthday')->comment('생년월일');
            $table->string('university')->nullable()->comment('대학교');
            $table->string('student_number')->nullable()->comment('학번');
            $table->tinyInteger('state')->comment('상태');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('qualification_id')->references('id')->on('certificate_qualifications');
            $table->foreign('completion_id')->references('id')->on('certificate_completions');
            $table->foreign('file_id')->references('id')->on('files');

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
        Schema::dropIfExists('certificate_profiles');
    }
}
