<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualification_profiles', function (Blueprint $table) {
            $table->integer('score')->default(0)->comment('점수');
            //
        });
        Schema::table('completion_profiles', function (Blueprint $table) {
            $table->integer('score')->default(0)->comment('점수');
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
            $table->dropColumn('score');
        });
        Schema::table('completion_profiles', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
}
