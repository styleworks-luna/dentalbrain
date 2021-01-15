<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오후 1:15
 */

namespace App\Services\StatusChange;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class StatusChangeImpl implements StatusChangeMethod{
    public function statusChange(Model $model, string $key){
        DB::beginTransaction();
        try{
            if($model->$key == '1'){
                $model->$key = 0;
                $model->save();
            } else{
                $model->$key = 1;
                $model->save();
            }
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
        }
    }
}