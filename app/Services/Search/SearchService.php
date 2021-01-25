<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-25
 * Time: 오전 9:45
 */

namespace App\Services\Search;



use Illuminate\Database\Eloquent\Model;

abstract class SearchService{

    protected $model;
    protected $keyword;
    protected $keywordCategories;
    protected $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model::query();
    }

    public function setSearchKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    public function addWhereKeyword(){
        if(isset($this->keyword)){
            foreach($this->keywordCategories as $key => $value){
                $this->query->where($value,'like','%'.$this->keyword.'%','or');
            }
        }
    }

    abstract function search();
}