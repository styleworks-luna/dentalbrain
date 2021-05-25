<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTicketColumnInProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
            $table->integer('is_free')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->comment('강의 가격')
                ->nullable()->after('thumbnail_id')->change();
            $table->string('description')->comment('강의 짧은 설명')
                ->nullable()->after('title')->change();
            $table->integer('is_free')->comment('강의 무료 여부 / 1 : true , 0 : false')
                ->nullable()->after('is_open')->change();
            $table->unsignedBigInteger('term')->comment('강의 수강 기간')
                ->default(100)->after('running_time')->change();
        });
    }
}
