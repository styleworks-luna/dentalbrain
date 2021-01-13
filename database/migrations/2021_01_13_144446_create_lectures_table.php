<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('thumbnail_id');
            $table->string('url');
            $table->string('youtube_id')->nullable()->default(null);
            $table->unsignedBigInteger('program_id');

            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('thumbnail_id')->references('id')->on('files');

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
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropForeign('lectures_program_id_foreign');
            $table->dropForeign('lectures_thumbnail_id_foreign');
        });
        Schema::dropIfExists('lectures');
    }
}
