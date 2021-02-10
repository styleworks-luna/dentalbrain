<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProgramStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_students', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id')->nullable()->after('user_id')
                ->comment('결제 정보');
            $table->dateTime('expired_at')->comment('소유 마감 기한')->nullable()->change();
            $table->foreign('payment_id')->references('id')->on('payments');
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
            $table->dropForeign('program_students_payment_id_foreign');
            $table->dropColumn('payment_id');
        });
    }
}
