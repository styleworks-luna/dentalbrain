<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCareerToResumes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('career_task_4')->nullable()->comment('경력사항 - 담당업무 4')->after('department_3');
            $table->string('career_company_4')->nullable()->comment('경력사항 - 치과명 4')->after('department_3');
            $table->string('career_ended_at_4')->nullable()->comment('경력사항 - 근무기간 끝 4')->after('department_3');
            $table->string('career_started_at_4')->nullable()->comment('경력사항 - 근무기간 시작 4')->after('department_3');

            $table->string('career_task_3')->nullable()->comment('경력사항 - 담당업무 3')->after('department_3');
            $table->string('career_company_3')->nullable()->comment('경력사항 - 치과명 3')->after('department_3');
            $table->string('career_ended_at_3')->nullable()->comment('경력사항 - 근무기간 끝 3')->after('department_3');
            $table->string('career_started_at_3')->nullable()->comment('경력사항 - 근무기간 시작 3')->after('department_3');

            $table->string('career_task_2')->nullable()->comment('경력사항 - 담당업무 2')->after('department_3');
            $table->string('career_company_2')->nullable()->comment('경력사항 - 치과명 2')->after('department_3');
            $table->string('career_ended_at_2')->nullable()->comment('경력사항 - 근무기간 끝 2')->after('department_3');
            $table->string('career_started_at_2')->nullable()->comment('경력사항 - 근무기간 시작 2')->after('department_3');

            $table->string('career_task_1')->nullable()->comment('경력사항 - 담당업무 1')->after('department_3');
            $table->string('career_company_1')->nullable()->comment('경력사항 - 치과명 1')->after('department_3');
            $table->string('career_ended_at_1')->nullable()->comment('경력사항 - 근무기간 끝 1')->after('department_3');
            $table->string('career_started_at_1')->nullable()->comment('경력사항 - 근무기간 시작 1')->after('department_3');

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
            $table->dropColumn('career_started_at_4');
            $table->dropColumn('career_ended_at_4');
            $table->dropColumn('career_company_4');
            $table->dropColumn('career_task_4');

            $table->dropColumn('career_started_at_3');
            $table->dropColumn('career_ended_at_3');
            $table->dropColumn('career_company_3');
            $table->dropColumn('career_task_3');

            $table->dropColumn('career_started_at_2');
            $table->dropColumn('career_ended_at_2');
            $table->dropColumn('career_company_2');
            $table->dropColumn('career_task_2');

            $table->dropColumn('career_started_at_1');
            $table->dropColumn('career_ended_at_1');
            $table->dropColumn('career_company_1');
            $table->dropColumn('career_task_1');
        });
    }
}
