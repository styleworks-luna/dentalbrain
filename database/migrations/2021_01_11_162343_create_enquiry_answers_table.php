<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('enquiry_id');
            $table->string('display_name')->nullable()->default(null);
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('user_id');

            $table->foreign('enquiry_id')->references('id')->on('enquiries');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::table('enquiry_answers', function (Blueprint $table) {
            $table->dropForeign('enquiry_answers_user_id_foreign');
            $table->dropForeign('enquiry_answers_enquiry_id_foreign');
        });
        Schema::dropIfExists('enquiry_answers');
    }
}
