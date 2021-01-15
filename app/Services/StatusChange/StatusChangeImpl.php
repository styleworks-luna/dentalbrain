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
            $this->statusChangeUpdate($model , $key);
            DB::commit();
            return response()->json([
                'success'=>true,
                'msg' => '성공하였습니다.'
            ]);
        }catch(\Exception $ex){
            logger($ex);
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'msg' => '실패하였습니다.'
            ]);
        }
    }
    public function statusChangeUpdate(Model $model, string $key){
        if($model->$key){
            $model->$key = 0;
            $model->save();
        } else{
            $model->$key = 1;
            $model->save();
        }
    }
}