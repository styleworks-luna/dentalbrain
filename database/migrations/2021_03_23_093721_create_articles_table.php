<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title')->comment('제목');
            $table->unsignedBigInteger('thumbnail_id')->comment('썸네일 ID');
            $table->string('link')->comment('링크');
            $table->dateTime('date')->comment('작성 일자');

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
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('articles_thumbnail_id_foreign');
        });
        Schema::dropIfExists('articles');
    }
}
