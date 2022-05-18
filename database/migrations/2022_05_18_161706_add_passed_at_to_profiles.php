<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassedAtToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualification_profiles', function (Blueprint $table) {
            $table->timestamp('passed_at')->nullable()->default(null)->comment('합격 시간');
            //
        });
        Schema::table('completion_profiles', function (Blueprint $table) {
            $table->timestamp('passed_at')->nullable()->default(null)->comment('합격 시간');
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
            $table->dropColumn('passed_at');
        });
        Schema::table('completion_profiles', function (Blueprint $table) {
            $table->dropColumn('passed_at');
        });
    }
}
