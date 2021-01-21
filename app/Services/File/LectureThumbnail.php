<?php

namespace App\Services\File;

use App\Models\Program\Lecture;

class LectureThumbnail extends FileTemplate
{

    public function __construct(Lecture $lecture)
    {
        parent::__construct($lecture);
    }

    function getPublicPath(string $fileName)
    {
        $lecture = $this->model;
        return $path = 'public/program/' . $lecture->program->id . '/lecture/' . $lecture->id . '/' . $fileName;
    }

    function deleteFileInDB()
    {
        $lecture = $this->model;
        $path = $lecture->thumbnail->path;
        $lecture->thumbnail->delete();
        return $path;
    }
}
