<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCommentOfPayStatusColumnToProgramStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_students', function (Blueprint $table) {
            $table->integer('pay_status')
                ->comment('결제 상태, 0 : 결제 전 | 1 : 결제 중 | 2 : 결제 완료 | 3 : 환불됨 | 4 : 환불 요청됨.')
                ->change();
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
            $table->integer('pay_status')
                ->comment('결제 상태, 0 : 결제 전 | 1 : 결제 중 | 2 : 결제 완료 | 3 : 환불됨')
                ->change();
        });
    }
}
