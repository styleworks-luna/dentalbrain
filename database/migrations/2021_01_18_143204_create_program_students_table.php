<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ticket_id')->comment('수강권 일련번호');
            $table->dateTime('expired_at')->comment('소유 마감 기한');
            $table->string('email')->comment('이메일 (NOT users.email)');
            $table->string('phone')->comment('전화번호 (NOT users.phone)');
            $table->tinyInteger('is_repeated')->default(0)->comment('재수강 여부');
            $table->dateTime('applied_at')->comment('신청 시점');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ticket_id')->references('id')->on('program_tickets');

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
        Schema::table('program_students', function (Blueprint $table) {
            $table->dropForeign('program_students_user_id_foreign');
            $table->dropForeign('program_students_ticket_id_foreign');
        });
        Schema::dropIfExists('program_students');
    }
}
