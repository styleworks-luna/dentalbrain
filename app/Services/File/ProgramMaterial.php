<?php

namespace App\Services\File;

use App\Models\Program\Program;

class ProgramMaterial extends FileTemplate
{

    public function __construct(Program $program)
    {
        parent::__construct($program);
    }

    function getPublicPath(string $fileName)
    {
        $program = $this->model;
        return $path = 'public/program/' . $program->id . '/material/' . $fileName;
    }

    function deleteFileInDB()
    {
        $program = $this->model;
        $path = $program->material->path;
        $program->material->delete();
        return $path;
    }
}
