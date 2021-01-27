<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProgramTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_tickets', function (Blueprint $table) {
            $table->tinyInteger('is_free')->default(0)->comment('0 : 유료 | 1 : 무료');
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
            $table->dropColumn('is_free');
        });
    }
}
