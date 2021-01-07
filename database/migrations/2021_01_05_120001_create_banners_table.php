<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('clicks')->default(0)->comment('클릭 수');
            $table->tinyInteger('is_active')->default(1)->comment('0 : 비활성화 | 1 : 활성화');
            $table->tinyInteger('position')->default(0)->comment('0 : 상단배너 | 1 : 하단배너');
            $table->integer('order')->default(0)->comment('노출 순서');

            $table->string('link')->comment('링크');

            $table->dateTime('started_at')->comment('시작 시간');
            $table->dateTime('ended_at')->comment('종료 시간');

            $table->unsignedBigInteger('file_id');

            $table->foreign('file_id')->references('id')->on('files');

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
        Schema::table('banners', function (Blueprint $table) {
            $table->dropForeign('banners_file_id_foreign');
        });

        Schema::dropIfExists('banners');
    }
}
