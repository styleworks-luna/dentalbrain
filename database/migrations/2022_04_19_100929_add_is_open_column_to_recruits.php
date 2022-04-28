<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOpenColumnToRecruits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->tinyInteger('is_open')->default(1)->comment('0 : 비활성화 | 1 : 활성화')->after('id');
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
            $table->dropColumn('is_open');
        });
    }
}
