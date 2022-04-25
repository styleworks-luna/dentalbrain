<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameOfBenefitsNameToTypeBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_benefits')->where('id', 5)->update(['type' => '연월차']);
        DB::table('type_benefits')->where('id', 7)->update(['type' => '4대보험']);
        DB::table('type_benefits')->where('id', 10)->update(['type' => '퇴직금']);
        DB::table('type_benefits')->where('id', 11)->update(['type' => '야근수당']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('type_benefits')->where('id', 5)->update(['type' => '연월차지원']);
        DB::table('type_benefits')->where('id', 7)->update(['type' => '4대보험지원']);
        DB::table('type_benefits')->where('id', 10)->update(['type' => '퇴직금지원']);
        DB::table('type_benefits')->where('id', 11)->update(['type' => '야근수당지원']);
    }
}
