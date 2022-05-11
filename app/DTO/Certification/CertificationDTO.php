<?php

namespace App\DTO\Certification;

use Illuminate\Database\Eloquent\Model;

class CertificationDTO
{
    public $num;
    public $type;
    public $title;
    public $id;

    /**
     * @param $num
     * @param $type
     * @param $title
     * @param $id
     */
    public function __construct(int $num, string $type, Model $model)
    {
        $this->num = $num;
        $this->type = $type;
        $this->title = $model->title;
        $this->id = $model->id;
    }

}
