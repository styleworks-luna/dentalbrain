<?php

namespace App\Services\File;

use App\Models\Program\Lecture;

class LectureThumbnail extends FileTemplate
{

    public function __construct(Lecture $lecture)
    {
        parent::__construct($lecture);
    }

    protected function getSavePath(string $fileName)
    {
        $lecture = $this->model;
        return $path = 'public/program/' . $lecture->program->id . '/lecture/' . $lecture->id . '/' . $fileName;
    }

    protected function deleteFileInDB()
    {
        $lecture = $this->model;
        if ($lecture->thumbnail == null) {
            return false;
        }
        $path = $lecture->thumbnail->path;
        $lecture->thumbnail->delete();
        return $path;
    }
}
