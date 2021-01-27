<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserJobName;
use Illuminate\Support\Facades\DB;

class InsertNeedLicenseToUserJobNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userJobName = DB::table('user_job_names')->whereIn('name', ['치과의사','치과위생사','치과조무사'])->get();
        foreach($userJobName as $userJobValue){
            DB::table('user_job_names')->where('id',$userJobValue->id)->update(['need_license'=>1]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $userJobName = DB::table('user_job_names')->whereIn('name', ['치과의사','치과위생사','치과조무사'])->get();
        foreach($userJobName as $userJobValue){
            DB::table('user_job_names')->where('id',$userJobValue->id)->update(['need_license'=>0]);
        }
    }
}
