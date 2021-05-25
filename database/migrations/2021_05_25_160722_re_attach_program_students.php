<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReAttachProgramStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_students', function (Blueprint $table) {
            $table->dropForeign('program_students_ticket_id_foreign');
        });

        Schema::table('program_students', function (Blueprint $table) {
            $table->renameColumn('ticket_id', 'program_id');
        });

        Schema::table('program_students', function (Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('programs');
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
            $table->dropForeign('program_students_program_id_foreign');
        });

        Schema::table('program_students', function (Blueprint $table) {
            $table->renameColumn('program_id', 'ticket_id');
        });

        Schema::table('program_students', function (Blueprint $table) {
            $table->foreign('ticket_id')->references('id')->on('program_tickets');
        });
    }
}
