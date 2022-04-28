<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsIamportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_iamport', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('merchant_id');
            $table->string('pay_method');

            $table->string('channel');

            $table->string('pg_provider');
            $table->string('pg_tid');
            $table->string('pg_id');

            $table->boolean('escrow');
            $table->string('apply_num');

            $table->string('bank_code');
            $table->string('bank_name');

            $table->string('card_code');
            $table->string('card_name');
            $table->integer('card_quota');
            $table->string('card_number');
            $table->integer('card_type');

            $table->string('vbank_code');
            $table->string('vbank_name');
            $table->string('vbank_num');
            $table->string('vbank_holder');
            $table->integer('vbank_date');
            $table->integer('vbank_issued_at');

            $table->string('name');
            $table->integer('amount');

            $table->integer('cancel_amount');
            $table->string('currency');

            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_tel');
            $table->string('buyer_addr');
            $table->string('buyer_postcode');

            $table->string('custom_data');

            $table->string('user_agent');
            $table->string('status');

            $table->integer('paid_at');
            $table->integer('failed_at');
            $table->integer('cancelled_at');

            $table->string('fail_reason');
            $table->string('cancel_reason');

            $table->string('receipt_url');

            $table->string('cancel_history');
            $table->string('cancel_receipt_urls');

            $table->boolean('cash_receipt_issued');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_iamport');
    }
}
