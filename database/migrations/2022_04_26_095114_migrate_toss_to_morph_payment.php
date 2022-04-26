<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateTossToMorphPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            insert into payments (pg_id, pg_type, created_at)
            select `id`, 'toss', created_at
            from `payments_toss`;
         */

        DB::statement(
            'insert into payments (pg_id, pg_type, created_at)
            select `id`, ?, created_at
            from `payments_toss`', ['toss']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('payments')->truncate();
    }
}
