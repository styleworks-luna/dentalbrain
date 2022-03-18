<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviewColumnToProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('preview_id')->nullable()->comment('미리보기 id')->after('membership_price');
            $table->string('preview_type')->nullable()->comment('미리보기 type')->after('membership_price');
            $table->string('preview_url')->nullable()->comment('미리보기 url')->after('membership_price');
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
            $table->dropColumn('preview_url');
            $table->dropColumn('preview_type');
            $table->dropColumn('preview_id');
        });
    }
}
