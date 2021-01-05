<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('license_num')->nullable();

            $table->unsignedBigInteger('job_id');

            $table->foreign('job_id')->references('id')->on('user_jobs');

            $table->softDeletes();

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
        Schema::table('user_licenses',function (Blueprint $table) {
            $table->dropForeign('user_licenses_job_id_foreign');
        });

        Schema::dropIfExists('user_licenses');
    }
}
