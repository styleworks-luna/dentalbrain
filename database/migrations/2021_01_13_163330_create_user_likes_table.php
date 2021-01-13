<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('program_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('program_id')->references('id')->on('programs');

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
        Schema::table('user_likes', function (Blueprint $table) {
            $table->dropForeign('user_likes_user_id_foreign');
            $table->dropForeign('user_likes_program_id_foreign');
        });
        Schema::dropIfExists('user_likes');
    }
}
