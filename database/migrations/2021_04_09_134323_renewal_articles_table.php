<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenewalArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('articles_thumbnail_id_foreign');
        });
        Schema::dropIfExists('articles');

        //===========================================================================

        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');

            $table->string('title')->comment('제목');
            $table->text('content')->comment('내용');
            $table->string('writer')->comment('작성자');
            $table->dateTime('date')->comment('작성 일자');

            $table->integer('is_open')->comment('공개 여부')->default(1);

            $table->unsignedBigInteger('views')->comment('조회수')->default(0);


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
        Schema::dropIfExists('articles');

        //===========================================================================

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
}
