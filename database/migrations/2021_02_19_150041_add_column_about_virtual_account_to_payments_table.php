<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAboutVirtualAccountToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('refundStatus');
            $table->string('va_refundStatus')->nullable()->comment('가상계좌 환불상태')->after('status');
            $table->string('va_dueDate')->nullable()->comment('가상계좌 납입기한')->after('status');
            $table->string('va_customerName')->nullable()->comment('가상계좌 예금주명')->after('status');
            $table->string('va_bank')->nullable()->comment('가상계좌 입금 은행')->after('status');
            $table->string('va_accountNumber')->nullable()->comment('가상계좌 입금 계좌')->after('status');

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
            $table->string('refundStatus')->nullable()
                ->comment('환불 처리 상태입니다.')->after('status');
            $table->dropColumn('va_accountNumber');
            $table->dropColumn('va_bank');
            $table->dropColumn('va_customerName');
            $table->dropColumn('va_dueDate');
            $table->dropColumn('va_refundStatus');
        });
    }
}
