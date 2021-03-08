<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_cancels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->integer('cancelAmount')->comment('결제 취소 금액');
            $table->string('cancelReason')->comment('결제 취소 사유');
            $table->integer('taxFreeAmount')->nullable()->comment('과세로 처리된 금액');
            $table->integer('refundableAmount')->comment('결제 취소 이후 환불 가능한 잔액');
            $table->dateTime('canceledAt')->comment('결제 취소 일시');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_cancels', function (Blueprint $table) {
            $table->dropForeign('payment_cancels_payment_id_foreign');
        });

        Schema::dropIfExists('payment_cancels');
    }
}
