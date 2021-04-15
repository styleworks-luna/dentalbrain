<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToArticleLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('좋아요 한 유저');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_likes', function (Blueprint $table) {
            $table->dropForeign('article_likes_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
