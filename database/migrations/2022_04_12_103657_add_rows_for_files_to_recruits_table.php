<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRowsForFilesToRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dateTime('started_at')->nullable()->comment('모집 시작일')->change();
            $table->dateTime('ended_at')->nullable()->comment('모집 마감일')->change();

            $table->unsignedBigInteger('file_3_id')->nullable()->comment('기타 사진 3')->after('payment_id');
            $table->unsignedBigInteger('file_2_id')->nullable()->comment('기타 사진 2')->after('payment_id');
            $table->unsignedBigInteger('file_1_id')->nullable()->comment('기타 사진 1')->after('payment_id');
            $table->unsignedBigInteger('main_file_id')->nullable()->comment('치과 대표 사진')->after('payment_id');

            $table->foreign('main_file_id')->references('id')->on('files');
            $table->foreign('file_1_id')->references('id')->on('files');
            $table->foreign('file_2_id')->references('id')->on('files');
            $table->foreign('file_3_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dateTime('started_at')->comment('모집 시작일')->change();
            $table->dateTime('ended_at')->comment('모집 마감일')->change();

            $table->dropForeign(['main_file_id']);
            $table->dropForeign(['file_1_id']);
            $table->dropForeign(['file_2_id']);
            $table->dropForeign(['file_3_id']);

            $table->dropColumn('main_file_id');
            $table->dropColumn('file_1_id');
            $table->dropColumn('file_2_id');
            $table->dropColumn('file_3_id');


        });
    }
}
