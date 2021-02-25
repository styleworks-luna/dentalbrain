<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsWatchedToProgramStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_students', function (Blueprint $table) {
            $table->tinyInteger('is_watched')
                ->default(0)
                ->after('is_repeated')
                ->comment('시청 여부');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_students', function (Blueprint $table) {
            $table->dropColumn('is_watched');
        });
    }
}
