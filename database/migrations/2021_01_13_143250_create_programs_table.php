<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('강의 제목');
            $table->text('description')->comment('강의 설명');
            $table->unsignedBigInteger('thumbnail_id')->comment('썸네일 아이디 *(files FK)');
            $table->dateTime('started_at')->comment('접수 시작일');
            $table->dateTime('ended_at')->comment('접수 마감일');
            $table->tinyInteger('is_online')->default('1')->comment('0 : 오프라인 | 1 : 온라인');
            $table->string('running_time')->comment('러닝타임 표기');


            $table->unsignedBigInteger('material_id')->nullable()->comment('강의 자료 *(files FK)');
            $table->unsignedBigInteger('major_category_id')->comment('대분류 id');
            $table->unsignedBigInteger('minor_category_id')->comment('소분류 id');

            $table->foreign('thumbnail_id')->references('id')->on('files');
            $table->foreign('material_id')->references('id')->on('files');
            $table->foreign('major_category_id')->references('id')->on('program_major_categories');
            $table->foreign('minor_category_id')->references('id')->on('program_minor_categories');

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
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign('programs_thumbnail_id_foreign');
            $table->dropForeign('programs_material_id_foreign');
            $table->dropForeign('programs_major_category_id_foreign');
            $table->dropForeign('programs_minor_category_id_foreign');
        });
        Schema::dropIfExists('programs');
    }
}
