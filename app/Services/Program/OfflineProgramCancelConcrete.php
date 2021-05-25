<?php


namespace App\Services\Program;


class OfflineProgramCancelConcrete extends ProgramCancelTemplate
{
    public function __construct()
    {
        $is_online = false;
        parent::__construct($is_online);
    }
}
