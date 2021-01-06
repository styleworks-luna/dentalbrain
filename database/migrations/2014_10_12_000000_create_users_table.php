<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('phone')->unique();

            $table->unsignedTinyInteger('is_admin')->default('0')->comment('0 : 일반 유저 | 1 : 관리자');

            $table->string('api_token')->nullable()->default(null)->unique()->comment('API TOKEN');

            $table->timestamp('last_login_at')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
