<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->datetime('answered_at')->nullable()->comment('답변 시간');
            $table->unsignedBigInteger('category_id')->default(1)->comment('문의 내역 구분');
            $table->foreign('category_id')->references('id')->on('inquiry_categories');
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
            $table->dropForeign('inquiries_category_id_foreign');

            $table->tinyInteger('category');
            $table->dropColumn('category_id');
            $table->dropColumn('answered_at');
        });
    }
}
