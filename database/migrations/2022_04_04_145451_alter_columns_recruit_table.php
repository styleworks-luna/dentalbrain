<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsRecruitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruit_salaries', function (Blueprint $table) {
            $table->string('value')->nullable()->comment('급여 값')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruit_salaries', function (Blueprint $table) {
            $table->string('value')->comment('급여 값')->change();
        });
    }
}
