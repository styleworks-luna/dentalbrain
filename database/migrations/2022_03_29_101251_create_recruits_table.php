<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('사용자 정보');
            $table->unsignedBigInteger('payment_id')->nullable()->comment('결제 정보');
            $table->string('company_name')->comment('회사명');
            $table->string('company_leader')->comment('대표자 명');
            $table->string('company_license')->comment('사업자 등록 번호');
            $table->string('company_phone')->comment('회사 전화번호');

            $table->string('name')->comment('담당자 명');
            $table->string('phone')->comment('담당자 전화번호');
            $table->string('email')->comment('담당자 이메일');
            $table->string('url')->comment('홈페이지 주소');

            $table->string('address')->comment('치과 주소');
            $table->string('address_detail')->nullable()->comment('치과 상세 주소');
            $table->string('sido')->nullable()->comment('시 / 도');
            $table->string('gugun')->nullable()->comment('구 / 군');
            $table->string('dong')->nullable()->comment('동');
            $table->double('latitude')->comment('위도');
            $table->double('longitude')->comment('경도');

            $table->string('subway')->nullable()->comment('인근 지하철역');
            $table->integer('career')->comment('경력');

            $table->unsignedBigInteger('type_work_id')->comment('근무형태 정보');
            $table->unsignedBigInteger('type_job_id')->comment('직종 정보');
            $table->unsignedBigInteger('type_study_id')->comment('학력 정보');

            $table->dateTime('started_at')->comment('모집 시작일');
            $table->dateTime('ended_at')->comment('모집 마감일');
            $table->longText('content')->comment('상세 내용');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('type_work_id')->references('id')->on('type_works');
            $table->foreign('type_job_id')->references('id')->on('type_jobs');
            $table->foreign('type_study_id')->references('id')->on('type_studies');

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
        Schema::dropIfExists('recruits');
    }
}
