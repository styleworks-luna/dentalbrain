<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-25
 * Time: 오후 4:13
 */

namespace  App\Services\Search;
use Illuminate\Database\Eloquent\Model;

class NoticeSearchImpl extends SearchService{

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->keywordCategories = ['title','content'];
    }

    public function search()
    {
        $this->addWhereKeyword();
        return $this->query->get();
    }
}