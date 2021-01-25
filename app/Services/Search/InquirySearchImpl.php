<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-25
 * Time: 오후 3:32
 */

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Model;

class InquirySearchImpl extends SearchService{

    private $gubun;

    function __construct(Model $model)
    {
        parent::__construct($model);
        $this->keywordCategories = ['title','content'];
    }

    public function setGubun($gubun){
        $this->gubun = $gubun;
    }

    public function search(){
        $this->addWhereQueryByGubun();
        $this->addWhereKeyword();
        return $this->query->get();
    }

    public function addWhereQueryByGubun(){
        switch($this->gubun){
            case 'notCompleted':
                $this->query->where('is_answer',0);
                break;
            case 'Completed':
                $this->query->where('is_answer',1);
                break;
            case 'normal':
                $this->query->where('category_id',1);
                break;
            case 'refund':
                $this->query->where('category_id',2);
                break;
            default:
            case 'all':
                break;
        }
    }
}