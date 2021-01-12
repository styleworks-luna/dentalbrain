<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-12
 * Time: 오후 3:19
 */
namespace App\Interfaces\ViewCount;

use App\Interfaces\ViewCount\ViewCountMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ViewCountImpl implements ViewCountMethod{

    public function viewCountAdd(Model $model){
        $model->increment('views');
    }
}