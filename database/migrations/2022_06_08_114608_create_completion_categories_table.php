<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completion_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('수료증 종류 이름');
        });
        Schema::create('qualification_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('자격증 종류 이름');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completion_categories');
        Schema::dropIfExists('qualification_categories');
    }
}
