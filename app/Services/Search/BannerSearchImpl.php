<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-25
 * Time: 오후 4:43
 */

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Model;

class BannerSearchImpl extends SearchService{

    private $position;
    private $date;

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->keywordCategories = ['link'];
    }

    public function search()
    {
        $this->addWhereKeyword();
        $this->addWherePosition();
        $this->addWhereDate();

        return $this->query->get();
    }

    public function setPosition($position){
        $this->position = $position;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function addWherePosition(){
        if(isset($this->position) && is_numeric($this->position))
            $this->query->where('position',$this->position);
    }

    public function addWhereDate(){
        if(isset($this->date)&& DateTime::createFromFormat('Y-m-d H:i:s', $this->date) !== FALSE ){
            $this->query->where('started_at', '<=', $this->date);
            $this->query->where('ended_at', '>=', $this->date);
        }
    }
}