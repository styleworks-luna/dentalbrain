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

class ViewCountImpl extends Model implements ViewCountMethod{
    public function __construct()
    {
        parent::__construct();
    }

    public function viewCountAdd(string $modelName , int $id){
        DB::table($modelName)->where('id',$id)->increment('views');
    }
}