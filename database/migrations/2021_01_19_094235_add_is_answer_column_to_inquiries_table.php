<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAnswerColumnToInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->tinyInteger('is_answer')->default(0)->comment('답변 상태')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('is_answer');
        });
    }
}
