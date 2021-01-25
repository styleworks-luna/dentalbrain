<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-25
 * Time: 오후 1:28
 */

namespace App\Services\Search;
use Illuminate\Database\Eloquent\Model;

class FaqSearchImpl extends SearchService{
    function __construct(Model $model)
    {
        parent::__construct($model);
        $this->keywordCategories = ['question','answer'];
    }

    public function search(){
        $this->addWhereKeyword();
        return $this->query->get();
    }
}