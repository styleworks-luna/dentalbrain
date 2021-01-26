<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-26
 * Time: 오전 9:59
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Services\Search\SearchService;
Trait SearchFunctions{
    public function addKeywordToSearchService(SearchService $searchService, array $keywordCategories, string $keyword=null){
        if(isset($keyword)) {
            array_map(function ($keyWordvalue) use ($searchService, $keyword) {
                return $searchService->addKeyword($keyWordvalue, $keyword);
            }, $keywordCategories);
        }
    }

    public function addCategoryToSearchService(SearchService $searchService, array $category=null){
        if(isset($category) && !empty($category)){
            $searchService->addCategory($category[0],$category[1],$category[2]);
        }
    }
}