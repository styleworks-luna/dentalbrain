<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignAboutPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });
        Schema::table('program_students', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->foreign(['payment_id'])->references('id')->on('payments_toss');
        });
        Schema::table('memberships', function (Blueprint $table) {
            $table->foreign(['payment_id'])->references('id')->on('payments_toss');
        });
        Schema::table('program_students', function (Blueprint $table) {
            $table->foreign(['payment_id'])->references('id')->on('payments_toss');
        });
    }
}
