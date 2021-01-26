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

     public function __construct(Builder $query){
        $this->categories = [];
         $this->searchKeywords = [];
         $this->query = $query;
     }

     public function addCategory(String $column, string $operator, $value){
         $this->categories[] = [$column,$operator,$value];
         return $this;
     }

     public function addKeyword(string $column, $value){
         $this->searchKeywords[] = [$column,'LIKE','%'.$value.'%','or'];
         return $this;
     }

     public function search(){
         return $this->query->where(function (Builder $query){
             $query->where($this->searchKeywords);
         })->where($this->categories);
     }
}