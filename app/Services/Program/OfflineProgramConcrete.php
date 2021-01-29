<?php


namespace App\Services\Program;


class OfflineProgramConcrete extends ProgramTemplate
{

    public function __construct()
    {
        $is_online = false;
        parent::__construct($is_online);
    }
}
