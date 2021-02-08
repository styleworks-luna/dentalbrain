<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('paymentKey')->comment('결제의 키 값');
            $table->string('orderId')->comment('주문 ID 값');

            $table->string('totalAmount')->comment('총 결제 금액');
            $table->string('receiptUrl')->nullable()
                ->comment('카드 영수증 or 취소 영수증 조회 페이지');

            $table->string('method')->comment('결제 수단');
            $table->string('status')
                ->comment('결제 처리 상태입니다. [ READY - 준비됨 | IN_PROGRESS - 진행중 | WAITING_FOR_DEPOSIT - 입금 대기 중 | DONE - 완료됨 | CANCELED - 취소됨 | ABORTED - 중단됨 | PARTIAL_CANCELED - 부분 취소됨 ]');
            $table->string('refundStatus')->nullable()
                ->comment('환불 처리 상태입니다.');

            $table->string('useDiscount')->comment('결제 시 즉시 할인 프로모션의 적용 여부입니다.');
            $table->string('discountAmount')->nullable()
                ->comment('즉시 할인 프로모션이 적용된 경우, 적용된 금액입니다.');
            $table->string('secret')->nullable()
                ->comment('가상계좌 결제 시 전달되는 입금 콜백을 검증하기 위한 값');

            $table->json('full_response')->comment('조회 결과 전문.');

            $table->dateTime('requestedAt')->comment('결제 요청 일시입니다');
            $table->dateTime('approvedAt')->comment('결제 승인 일시입니다.');

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
        Schema::dropIfExists('payments');
    }
}
