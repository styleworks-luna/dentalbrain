<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDiscoutColumnToProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('is_discount')->default(false)->comment('할인 여부')->after('price');
            $table->boolean('membership_is_discount')->default(false)->comment('유료회원 할인 여부')->after('membership_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('is_discount');
            $table->dropColumn('membership_is_discount');
        });
    }
}
