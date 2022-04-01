<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_benefits')->insert([
            ['type' => '점심제공'],
            ['type' => '유니폼'],
            ['type' => '주차'],
            ['type' => '자기계발비'],
            ['type' => '연월차지원'],
            ['type' => '휴가비지원'],
            ['type' => '4대보험지원'],
            ['type' => '연봉제'],
            ['type' => '인센티브제'],
            ['type' => '퇴직금 지원'],
            ['type' => '야근수당지원'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_benefits WHERE type_benefits.id >= 1");
        DB::statement("ALTER TABLE type_benefits AUTO_INCREMENT = 1");
    }
}
