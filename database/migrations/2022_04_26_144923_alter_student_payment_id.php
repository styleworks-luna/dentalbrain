<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterStudentPaymentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            update `program_students`, `payments` p
            set `program_students`.payment_id = p.id
            where `program_students`.payment_id = p.pg_id;
            ");

        Schema::table('program_students', function (Blueprint $table) {
            $table->foreign(['payment_id'])->references('id')->on('payments');
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
            $table->dropForeign(['payment_id']);
        });

        DB::statement("
            update `program_students`, `payments` p
            set `program_students`.payment_id = p.pg_id
            where `program_students`.payment_id = p.id
            ");

    }
}
