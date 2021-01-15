<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오후 1:15
 */
namespace App\Services\StatusChange;
use Illuminate\Database\Eloquent\Model;

interface StatusChangeMethod {
    function StatusChange(Model $model,string $key);
}