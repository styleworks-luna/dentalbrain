<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNameIsRefundToProgramStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_students', function (Blueprint $table) {
            $table->dropColumn('is_refund');
            $table->integer('pay_status')
                ->default(0)
                ->comment('결제 상태, 0 : 결제 전 | 1 : 결제 중 | 2 : 결제 완료 | 3 : 환불됨')->after('is_repeated');
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
            $table->dropColumn('pay_status');
            $table->tinyInteger('is_refund')->default(0)
                ->comment('환불 상태, 0 : 정상 | 1 : 환불')
                ->after('is_repeated');
        });
    }
}
