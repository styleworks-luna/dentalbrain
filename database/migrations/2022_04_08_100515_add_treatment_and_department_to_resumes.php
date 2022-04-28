<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTreatmentAndDepartmentToResumes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('department_3')->nullable()->comment('희망 순위 - 희망 진료과 3')->after('graduation_type');
            $table->string('department_2')->nullable()->comment('희망 순위 - 희망 진료과 2')->after('graduation_type');
            $table->string('department_1')->nullable()->comment('희망 순위 - 희망 진료과 1')->after('graduation_type');

            $table->string('treatment_3')->nullable()->comment('희망 순위 - 희망 부서 3')->after('graduation_type');
            $table->string('treatment_2')->nullable()->comment('희망 순위 - 희망 부서 2')->after('graduation_type');
            $table->string('treatment_1')->nullable()->comment('희망 순위 - 희망 부서 1')->after('graduation_type');
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
            $table->dropColumn('department_3');
            $table->dropColumn('department_2');
            $table->dropColumn('department_1');

            $table->dropColumn('treatment_3');
            $table->dropColumn('treatment_2');
            $table->dropColumn('treatment_1');
        });
    }
}
