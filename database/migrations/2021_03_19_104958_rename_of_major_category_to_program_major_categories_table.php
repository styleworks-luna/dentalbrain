<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameOfMajorCategoryToProgramMajorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('program_major_categories')->where('id', 1)->update(['name' => '경영']);
        DB::table('program_major_categories')->where('id', 2)->update(['name' => '임상']);
        DB::table('program_major_categories')->where('id', 3)->update(['name' => '상담']);
        DB::table('program_major_categories')->where('id', 4)->update(['name' => '데스크']);
        DB::table('program_major_categories')->where('id', 5)->update(['name' => '자격증']);
        DB::table('program_major_categories')->where('id', 6)->update(['name' => '치바시']);
        DB::table('program_major_categories')->where('id', 7)->update(['name' => '라이프']);
        DB::table('program_major_categories')->insert([
            ['name' => '유료회원'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('program_major_categories')->where('id', 1)->update(['name' => '유료 연간회원']);
        DB::table('program_major_categories')->where('id', 2)->update(['name' => '치과의사']);
        DB::table('program_major_categories')->where('id', 3)->update(['name' => '치과 위생사']);
        DB::table('program_major_categories')->where('id', 4)->update(['name' => '치과 코디네이터']);
        DB::table('program_major_categories')->where('id', 5)->update(['name' => '치과 조무사']);
        DB::table('program_major_categories')->where('id', 6)->update(['name' => '자격증']);
        DB::table('program_major_categories')->where('id', 7)->update(['name' => '치바시']);

        DB::table('program_major_categories')->where('id', '>', 7)
            ->delete();
        DB::statement("ALTER TABLE program_major_categories AUTO_INCREMENT = 8;");

    }
}
