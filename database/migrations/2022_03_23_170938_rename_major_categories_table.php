<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMajorCategoriesTable extends Migration
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
        DB::table('program_major_categories')->where('id', 6)->update(['name' => '라이프']);
        DB::table('program_major_categories')->where('id', 7)->update(['name' => '스토어']);
        DB::table('program_major_categories')->where('id', 8)->update(['name' => '유료회원']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('program_major_categories')->where('id', 1)->update(['name' => '경영']);
        DB::table('program_major_categories')->where('id', 2)->update(['name' => '임상']);
        DB::table('program_major_categories')->where('id', 3)->update(['name' => '상담']);
        DB::table('program_major_categories')->where('id', 4)->update(['name' => '데스크']);
        DB::table('program_major_categories')->where('id', 5)->update(['name' => '자격증']);
        DB::table('program_major_categories')->where('id', 6)->update(['name' => '치바시']);
        DB::table('program_major_categories')->where('id', 7)->update(['name' => '라이프']);
        DB::table('program_major_categories')->where('id', 8)->update(['name' => '유료회원']);

        DB::statement("ALTER TABLE program_major_categories AUTO_INCREMENT = 9;");
    }
}
