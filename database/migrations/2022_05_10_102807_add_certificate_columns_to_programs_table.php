<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCertificateColumnsToProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('completion_id')->nullable()->comment('수료증 ID')->after('minor_category_id');
            $table->unsignedBigInteger('qualification_id')->nullable()->comment('자격증 ID')->after('minor_category_id');

            $table->foreign('completion_id')->references('id')->on('certificate_completions');
            $table->foreign('qualification_id')->references('id')->on('certificate_qualifications');

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
            $table->dropForeign('programs_qualification_id_foreign');
            $table->dropForeign('programs_completion_id_foreign');

            $table->dropColumn('qualification_id');
            $table->dropColumn('completion_id');
        });
    }
}
