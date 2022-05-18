<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsIssuedToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualification_profiles', function (Blueprint $table) {
            $table->tinyInteger('is_issued')->default(false)->comment('발급 여부');
            //
        });
        Schema::table('completion_profiles', function (Blueprint $table) {
            $table->tinyInteger('is_issued')->default(false)->comment('발급 여부');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qualification_profiles', function (Blueprint $table) {
            $table->dropColumn('is_issued');
        });
        Schema::table('completion_profiles', function (Blueprint $table) {
            $table->dropColumn('is_issued');
        });
    }
}
