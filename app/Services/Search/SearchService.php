<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-25
 * Time: 오전 9:45
 */

namespace App\Services\Search;



use Illuminate\Database\Eloquent\Builder;

 class SearchService{
     private $query;
     private $categories;
     private $searchKeywords;
     private $joinModel;

     public function __construct(Builder $query){
        $this->categories = [];
         $this->searchKeywords = [];
         $this->query = $query;
         $this->joinModel = null;
     }

     public function addCategory(String $column, string $operator, $value){
         $this->categories[] = [$column,$operator,$value];
         return $this;
     }

     public function addKeyword(string $column, $value){
         $this->searchKeywords[] = [$column,'LIKE','%'.$value.'%','or'];
         return $this;
     }

     public function setJoinModel($modelName){
         $this->joinModel = $modelName;
     }

     public function search(){
        if(isset($this->joinModel)){
            return $this->joinSearch();
        }else{
            return $this->onlyModelsearch();
        }
     }

     public function onlyModelsearch(){
         return $this->query->where(function (Builder $query){
             $query->where($this->searchKeywords);
         })->where($this->categories);
     }

     public function joinSearch(){
         return $this->query->whereHas($this->joinModel,function(Builder $query){
            $query->where($this->searchKeywords);
         })->where($this->categories);
     }
}