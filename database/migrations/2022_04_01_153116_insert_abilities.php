<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertAbilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('abilities')->insert([
            ['category_id' => 1, 'input_name' => 'A01', 'name' => '임플란트 수술 어시스트', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 1, 'input_name' => 'A02', 'name' => '임플란트 인상채득', 'seq' => 1, 'type' => 'select'],
            ['category_id' => 1, 'input_name' => 'A03', 'name' => '임플란트 셋팅', 'seq' => 2, 'type' => 'select'],
            ['category_id' => 1, 'input_name' => 'A04', 'name' => '사용했던 임플란트 종류', 'seq' => 3, 'type' => 'text'],

            ['category_id' => 2, 'input_name' => 'B01', 'name' => '어시스트', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B02', 'name' => '구치부 싱글크라운 인상채득', 'seq' => 1, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B03', 'name' => '구치부 싱글크라운 임시치아', 'seq' => 2, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B04', 'name' => '전치부 싱글크라운 인상채득', 'seq' => 3, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B05', 'name' => '전치부 싱글크라운 임시치아', 'seq' => 4, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B06', 'name' => '구치부 브릿지 인상채득', 'seq' => 5, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B07', 'name' => '구치부 브릿지 임시치아', 'seq' => 6, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B08', 'name' => '전치부 브릿지 인상채득', 'seq' => 7, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B09', 'name' => '전치부 브릿지 임시치아', 'seq' => 8, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B10', 'name' => '싱글크라운 셋팅', 'seq' => 9, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B11', 'name' => '싱글크라운 [여러개] 셋팅', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B12', 'name' => '브릿지 셋팅', 'seq' => 1, 'type' => 'select'],
            ['category_id' => 2, 'input_name' => 'B13', 'name' => 'resin core', 'seq' => 2, 'type' => 'select'],

            ['category_id' => 3, 'input_name' => 'C01', 'name' => '스켈링', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 3, 'input_name' => 'C02', 'name' => 'curette', 'seq' => 1, 'type' => 'select'],

            ['category_id' => 4, 'input_name' => 'D01', 'name' => '전문가미백', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 4, 'input_name' => 'D02', 'name' => '자가미백', 'seq' => 1, 'type' => 'select'],

            ['category_id' => 5, 'input_name' => 'E01', 'name' => '교정과 보험청구', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 5, 'input_name' => 'E02', 'name' => '교정외 보험청구', 'seq' => 1, 'type' => 'select'],

            ['category_id' => 6, 'input_name' => 'F01', 'name' => '러버댐 장착', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F02', 'name' => '인레이 셋팅', 'seq' => 1, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F03', 'name' => '전치부 레진 필링', 'seq' => 2, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F04', 'name' => '구치부 레진 필링', 'seq' => 3, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F05', 'name' => 'CA 레진 필링', 'seq' => 4, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F06', 'name' => 'base 도포', 'seq' => 5, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F07', 'name' => '실란트', 'seq' => 6, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F08', 'name' => '불소 도포', 'seq' => 7, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F09', 'name' => 'PA 촬영 [구내엑스레이촬영]', 'seq' => 8, 'type' => 'select'],
            ['category_id' => 6, 'input_name' => 'F10', 'name' => 'pano 촬영', 'seq' => 9, 'type' => 'select'],

            ['category_id' => 7, 'input_name' => 'G01', 'name' => 'ceph 촬영', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G02', 'name' => '교정환자 cleansing', 'seq' => 1, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G03', 'name' => '와이어 넣기', 'seq' => 2, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G04', 'name' => '와이어 결찰', 'seq' => 3, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G05', 'name' => '진단 모델 인상채득', 'seq' => 4, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G06', 'name' => '마운팅', 'seq' => 5, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G07', 'name' => 'E/O 촬영', 'seq' => 6, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G08', 'name' => 'I/O 촬영', 'seq' => 7, 'type' => 'select'],
            ['category_id' => 7, 'input_name' => 'G09', 'name' => '석고 붓기', 'seq' => 8, 'type' => 'select'],

            ['category_id' => 8, 'input_name' => 'H01', 'name' => '임플란트 상담', 'seq' => 0, 'type' => 'select'],
            ['category_id' => 8, 'input_name' => 'H02', 'name' => '보철 상담', 'seq' => 1, 'type' => 'select'],
            ['category_id' => 8, 'input_name' => 'H03', 'name' => '덴쳐 상담', 'seq' => 2, 'type' => 'select'],
            ['category_id' => 8, 'input_name' => 'H04', 'name' => '교정 상담', 'seq' => 3, 'type' => 'select'],

            ['category_id' => 9, 'input_name' => 'I01', 'name' => 'Open & Setting', 'seq' => 0, 'type' => 'select'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('abilities')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
