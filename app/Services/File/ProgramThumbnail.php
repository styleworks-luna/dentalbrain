<?php

namespace App\Services\File;

use App\Models\Program\Program;

class ProgramThumbnail extends FileTemplate
{

    public function __construct(Program $program)
    {
        parent::__construct($program);
    }

    function getPublicPath(string $fileName)
    {
        $program = $this->model;
        return $path = 'public/program/' . $program->id . '/thumbnail/' . $fileName;
    }

    function deleteFileInDB()
    {
        $program = $this->model;
        $path = $program->thumbnail->path;
        $program->thumbnail->delete();
        return $path;
    }
}
