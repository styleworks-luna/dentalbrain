<?php


namespace App\Services\Program;


class OnlineProgramCancelConcrete extends ProgramCancelTemplate
{
    public function __construct()
    {
        $is_online = true;
        parent::__construct($is_online);
    }
}
