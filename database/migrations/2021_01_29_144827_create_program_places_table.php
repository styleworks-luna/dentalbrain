<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('program_id');

            $table->string('address')->comment('전체 주소');
            $table->string('address_detail')->nullable()->comment('상세 주소');

            $table->string('sido')->nullable()->comment('시 / 도');
            $table->string('gugun')->nullable()->comment('구 / 군');
            $table->string('dong')->nullable()->comment('동');

            $table->double('latitude')->comment('위도');
            $table->double('longitude')->comment('경도');

            $table->integer('capacity')->comment('정원');

            $table->dateTime('started_at')->comment('강의 시작 시간');
            $table->dateTime('ended_at')->comment('강의 종료 시간');

            $table->dateTime('receipt_started_at')->comment('접수 시작 시간');
            $table->dateTime('receipt_ended_at')->comment('접수 마감 시간');

            $table->foreign('program_id')->references('id')->on('programs');

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
        Schema::table('program_places', function (Blueprint $table) {
            $table->dropForeign('program_places_program_id_foreign');
        });

        Schema::dropIfExists('program_places');
    }
}
