<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();

            $table->string('work_area')->nullable()->comment('희망 근무 지역');
            $table->string('work_day')->nullable()->comment('희망 근무 요일');
            $table->string('work_time')->nullable()->comment('희망 근무 시간');

            $table->string('name')->nullable(false)->comment('이름');
            $table->string('english_name')->nullable(false)->comment('영문 이름');
            $table->string('birthday')->nullable(false)->comment('생년 월일');
            $table->string('phone')->nullable(false)->comment('휴대폰 번호');
            $table->string('emergency_phone')->nullable(false)->comment('비상 연락처');
            $table->string('email')->nullable(false)->comment('이메일 주소');
            $table->string('address')->nullable(false)->comment('주소');

            $table->string('graduated_at')->nullable()->comment('학위 취득연월');
            $table->string('school')->nullable()->comment('출신학교');
            $table->string('major')->nullable()->comment('학과 (세부전공)');
            $table->string('degree')->nullable()->comment('학위');
            $table->string('graduation_type')->nullable()->comment('졸업 구분');
            $table->text('about_me')->nullable()->comment('자기 소개');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('file_id')->references('id')->on('files');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('ability_answers');
        Schema::dropIfExists('resumes');
    }
}
