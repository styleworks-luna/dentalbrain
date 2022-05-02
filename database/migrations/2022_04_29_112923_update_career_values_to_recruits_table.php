<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateCareerValuesToRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('recruits')
            ->whereBetween('career', [1, 9])->update(['career' => 2]);
        DB::table('recruits')
            ->whereBetween('career', [10, 19])->update(['career' => 3]);
        DB::table('recruits')
            ->whereBetween('career', [20, 29])->update(['career' => 4]);
        DB::table('recruits')
            ->where('career', '>=', 30)->update(['career' => 5]);
        DB::table('recruits')
            ->where('career', '=',0)->update(['career' => 1]);

        DB::statement("ALTER TABLE recruits MODIFY career BIGINT UNSIGNED NOT NULL");

        Schema::table('recruits', function (Blueprint $table) {
            $table->renameColumn('career', 'type_career_id');
            $table->foreign('type_career_id')->references('id')->on('type_careers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dropForeign(['type_career_id']);
            $table->renameColumn('type_career_id', 'career');
        });

        DB::statement("ALTER TABLE recruits MODIFY career INTEGER NOT NULL");

        DB::table('recruits')
            ->where('career', 5)->update(['career' => 30]);
        DB::table('recruits')
            ->where('career', 4)->update(['career' => 25]);
        DB::table('recruits')
            ->where('career', 3)->update(['career' => 15]);
        DB::table('recruits')
            ->where('career', 2)->update(['career' => 5]);
        DB::table('recruits')
            ->where('career', 1)->update(['career' => 0]);
    }
}
