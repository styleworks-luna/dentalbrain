<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCertificateInfoToResumes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('certificate_agency_5')->nullable()->comment('면허/자격증 보유 현황 - 인가,관리기관 5')->after('graduation_type');
            $table->string('certificate_day_5')->nullable()->comment('면허/자격증 보유 현황 - 취득년월 5')->after('graduation_type');
            $table->string('certificate_name_5')->nullable()->comment('면허/자격증 보유 현황 - 자격증명 5')->after('graduation_type');

            $table->string('certificate_agency_4')->nullable()->comment('면허/자격증 보유 현황 - 인가,관리기관 4')->after('graduation_type');
            $table->string('certificate_day_4')->nullable()->comment('면허/자격증 보유 현황 - 취득년월 4')->after('graduation_type');
            $table->string('certificate_name_4')->nullable()->comment('면허/자격증 보유 현황 - 자격증명 4')->after('graduation_type');

            $table->string('certificate_agency_3')->nullable()->comment('면허/자격증 보유 현황 - 인가,관리기관 3')->after('graduation_type');
            $table->string('certificate_day_3')->nullable()->comment('면허/자격증 보유 현황 - 취득년월 3')->after('graduation_type');
            $table->string('certificate_name_3')->nullable()->comment('면허/자격증 보유 현황 - 자격증명 3')->after('graduation_type');

            $table->string('certificate_agency_2')->nullable()->comment('면허/자격증 보유 현황 - 인가,관리기관 2')->after('graduation_type');
            $table->string('certificate_day_2')->nullable()->comment('면허/자격증 보유 현황 - 취득년월 2')->after('graduation_type');
            $table->string('certificate_name_2')->nullable()->comment('면허/자격증 보유 현황 - 자격증명 2')->after('graduation_type');

            $table->string('certificate_agency_1')->nullable()->comment('면허/자격증 보유 현황 - 인가,관리기관 1')->after('graduation_type');
            $table->string('certificate_day_1')->nullable()->comment('면허/자격증 보유 현황 - 취득년월 1')->after('graduation_type');
            $table->string('certificate_name_1')->nullable()->comment('면허/자격증 보유 현황 - 자격증명 1')->after('graduation_type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('certificate_name_5');
            $table->dropColumn('certificate_day_5');
            $table->dropColumn('certificate_agency_5');

            $table->dropColumn('certificate_name_4');
            $table->dropColumn('certificate_day_4');
            $table->dropColumn('certificate_agency_4');

            $table->dropColumn('certificate_name_3');
            $table->dropColumn('certificate_day_3');
            $table->dropColumn('certificate_agency_3');

            $table->dropColumn('certificate_name_2');
            $table->dropColumn('certificate_day_2');
            $table->dropColumn('certificate_agency_2');

            $table->dropColumn('certificate_name_1');
            $table->dropColumn('certificate_day_1');
            $table->dropColumn('certificate_agency_1');
        });
    }
}
