<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class AlterBirthdayColumnToQualificationAndCompletionProfilesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE completion_profiles MODIFY birthday DATETIME NOT NULL');
        DB::statement('ALTER TABLE qualification_profiles MODIFY birthday DATETIME NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE completion_profiles MODIFY birthday VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE qualification_profiles MODIFY birthday VARCHAR(255) NOT NULL');
    }
}
