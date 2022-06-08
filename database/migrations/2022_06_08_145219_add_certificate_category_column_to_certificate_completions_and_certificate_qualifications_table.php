<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCertificateCategoryColumnToCertificateCompletionsAndCertificateQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificate_completions', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->comment('수료증 종류')->default(1)->after('id');
            $table->foreign('category_id')->references('id')->on('completion_categories');
        });
        Schema::table('certificate_qualifications', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->comment('자격증 종류')->default(1)->after('id');
            $table->foreign('category_id')->references('id')->on('qualification_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate_completions', function (Blueprint $table) {
            $table->dropForeign('certificate_completions_category_id_foreign');
            $table->dropColumn('category_id');
        });
        Schema::table('certificate_qualifications', function (Blueprint $table) {
            $table->dropForeign('certificate_qualifications_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
