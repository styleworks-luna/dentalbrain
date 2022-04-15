<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiredAtColumnsToRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dateTime('expired_at')->nullable()->comment('노출 날짜')->after('type_study_id');
            $table->unsignedBigInteger('term')->default(7)->comment('노출 기간')->after('type_study_id');
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
            $table->dropColumn('term');
            $table->dropColumn('expired_at');
        });
    }
}
