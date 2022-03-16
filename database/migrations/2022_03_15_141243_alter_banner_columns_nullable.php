<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBannerColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table)
        {
            $table->unsignedBigInteger('mobile_file_id')->nullable()->comment('모바일 파일 사진')->change();
            $table->unsignedBigInteger('desktop_file_id')->nullable()->comment('데스크탑 파일 사진')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
