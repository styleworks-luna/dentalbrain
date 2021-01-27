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
     private $joinOptions;

     public function __construct(Builder $query){
        $this->categories = [];
         $this->searchKeywords = [];
         $this->query = $query;
         $this->joinModel = null;
         $this->joinOptions = [];
     }

     public function addCategory(string $column, string $operator, $value){
         $this->categories[] = [$column,$operator,$value];
         return $this;
     }

     public function addKeyword(string $column, $value){
         if(isset($value)){
             $this->searchKeywords[] = [$column,'LIKE','%'.$value.'%','or'];
         }
         return $this;
     }

     public function join() {
         $this->query = $this->query->whereHas($this->joinModel,function(Builder $query){
             $query->where($this->joinOptions);
         });
         $this->joinModel = null;
         $this->joinOptions = [];
         return $this;
     }
     
     public function setJoinModel($modelName){
         $this->joinModel = $modelName;
         return $this;
     }

     public function addJoinOption(string $column, string $operator, $value){
        $this->joinOptions[] = [$column,$operator,$value];
        return $this;
     }

     public function search(){
         return $this->query->where(function (Builder $query){
             $query->where($this->searchKeywords);
         })->where($this->categories);
     }
}