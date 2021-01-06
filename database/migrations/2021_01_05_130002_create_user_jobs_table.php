<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_name_id');
            $table->string('license_num')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('job_name_id')->references('id')->on('user_job_names');

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
        Schema::table('user_jobs',function (Blueprint $table) {
            $table->dropForeign('user_jobs_user_id_foreign');
            $table->dropForeign('user_jobs_job_name_id_foreign');
        });

        Schema::dropIfExists('user_jobs');
    }
}
