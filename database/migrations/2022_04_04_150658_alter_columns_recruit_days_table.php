<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsRecruitDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruit_days', function (Blueprint $table) {
            $table->string('value')->nullable()->comment('근무요일 값')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruit_days', function (Blueprint $table) {
            $table->string('value')->comment('근무요일 값')->change();
        });
    }
}
