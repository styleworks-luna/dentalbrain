<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropForeign('banners_file_id_foreign');
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('file_id');
            $table->dropColumn('clicks');
            $table->dropColumn('is_active');
            $table->tinyInteger('is_open')->default(1)->comment('0 : 비활성화 | 1 : 활성화')->after('id');

            $table->unsignedBigInteger('desktop_file_id')->after('ended_at');
            $table->unsignedBigInteger('mobile_file_id')->after('ended_at');

            $table->integer('position')
                ->comment('0 : 상단배너 | 1 : 바배너 | 2 : 추천배너 | 3 : 하단배너')->change()->after('id');
            $table->string('title')->nullable()->after('position');

            $table->unsignedInteger('views')->default(0)->comment('조회 수')->after('user_id');

            $table->foreign('desktop_file_id')->references('id')->on('files');
            $table->foreign('mobile_file_id')->references('id')->on('files');
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
            $table->dropForeign('banners_desktop_file_id_foreign');
            $table->dropForeign('banners_mobile_file_id_foreign');

            $table->unsignedBigInteger('file_id');

            $table->foreign('file_id')->references('id')->on('files');
        });
    }
}
