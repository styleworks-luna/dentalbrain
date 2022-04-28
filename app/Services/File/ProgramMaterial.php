<?php

namespace App\Services\File;

use App\Models\Program\Program;

class ProgramMaterial extends FileTemplate
{

    public function __construct(Program $program)
    {
        parent::__construct($program);
    }

    function getDownloadUrl($path)
    {
        return route('api.lectures.download', [$this->model->id]);
    }

    protected function getSavePath(string $fileName)
    {
        $program = $this->model;
        // NOT PUBLIC
        return $path = 'program/' . $program->id . '/material/' . $fileName;
    }

    protected function deleteFileInDB()
    {
        $program = $this->model;
        $path = $program->material->path;
        $program->material->delete();
        return $path;
    }
}
