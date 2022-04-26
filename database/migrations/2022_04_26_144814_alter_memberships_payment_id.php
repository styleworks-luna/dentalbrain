<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterMembershipsPaymentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            update `memberships`, `payments` p
            set `memberships`.payment_id = p.id
            where `memberships`.payment_id = p.pg_id;
            ");

        Schema::table('memberships', function (Blueprint $table) {
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
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });

        DB::statement("
            update `memberships`, `payments` p
            set `memberships`.payment_id = p.pg_id
            where `memberships`.payment_id = p.id
            ");

    }
}
