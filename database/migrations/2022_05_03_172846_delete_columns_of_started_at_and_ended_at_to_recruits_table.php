2022_05_02_155303_delete_columns_of_started_at_and_ended_at_to_recruits_table

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnsOfStartedAtAndEndedAtToRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dropColumn('started_at');
            $table->dropColumn('ended_at');
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
            $table->dateTime('ended_at')->nullable()->comment('모집 마감일')->after('term');
            $table->dateTime('started_at')->nullable()->comment('모집 시작일')->after('term');;

        });
    }
}
