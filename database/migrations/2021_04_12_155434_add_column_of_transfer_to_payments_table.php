<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOfTransferToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('trans_settlementStatus')->comment('계좌이체 상태')->nullable()->after('va_refundStatus');
            $table->string('trans_bank')->comment('은행')->nullable()->after('va_refundStatus');
            $table->string('trans_accountNumber')->comment('계좌번호')->nullable()->after('va_refundStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('trans_settlementStatus');
            $table->dropColumn('trans_bank');
            $table->dropColumn('trans_accountNumber');
        });
    }
}
