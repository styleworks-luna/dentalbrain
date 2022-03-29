<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruit_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->comment('신청분야 타입');
            $table->unsignedBigInteger('recruit_id')->comment('구인 정보');
            $table->unsignedBigInteger('type_application_id')->comment('신청분야 정보');

            $table->foreign('recruit_id')->references('id')->on('recruits');
            $table->foreign('type_application_id')->references('id')->on('type_applications');

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
        Schema::dropIfExists('recruit_applications');
    }
}
