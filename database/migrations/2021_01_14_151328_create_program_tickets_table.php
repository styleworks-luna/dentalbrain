<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('term')->default(100)->comment('days');
            $table->string('name')->comment('강의 수강권 이름');

            $table->foreign('program_id')->references('id')->on('programs');

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
        Schema::table('program_tickets', function (Blueprint $table) {
            $table->dropForeign('program_tickets_program_id_foreign');
        });
        Schema::dropIfExists('program_tickets');
    }
}
