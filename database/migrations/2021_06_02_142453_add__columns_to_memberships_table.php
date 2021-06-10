<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dateTime('last_applied_at')->nullable()->after('pay_status')
                ->comment('신청시간');
            $table->unsignedBigInteger('applied_days')->nullable()->after('pay_status')
                ->comment('신청한 회원권 기간');
            $table->dateTime('expired_at')->comment('유료회원 종료 일자')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('last_applied_at');
            $table->dropColumn('applied_days');
            $table->dateTime('expired_at')->comment('유료회원 종료 일자')->nullable()->change();
        });
    }
}
