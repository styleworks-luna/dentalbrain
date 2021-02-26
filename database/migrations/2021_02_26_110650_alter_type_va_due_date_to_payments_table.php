<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeVaDueDateToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('va_dueDate');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dateTime('va_dueDate')->comment('가상계 납입 기한')
                ->nullable()->after('va_customerName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('va_dueDate');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->string('va_dueDate')->comment('가상계좌 납입 기한')
                ->nullable()->after('va_customerName');
        });
    }
}
