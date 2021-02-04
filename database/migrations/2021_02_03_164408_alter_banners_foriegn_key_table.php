<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBannersForiegnKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->unsignedBigInteger('position')->change();
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->renameColumn('position','category_id');
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('banner_categories');
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
            $table->dropForeign('banners_category_id_foreign');
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->renameColumn('category_id','position');
        });

    }
}
