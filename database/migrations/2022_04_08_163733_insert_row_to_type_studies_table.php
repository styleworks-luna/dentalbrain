<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertRowToTypeStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_studies')->insert([
            ['type' => '학력무관'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('recruits')
            ->where('type_study_id', '>', 13)
            ->update(
                ['type_study_id' => 1]
            );
        DB::delete("DELETE FROM type_studies WHERE type_studies.id > 13");
        DB::statement("ALTER TABLE type_studies AUTO_INCREMENT = 14");
    }
}
