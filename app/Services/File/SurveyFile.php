<?php


namespace App\Services\File;


use App\Models\File;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Support\Facades\Storage;

class SurveyFile extends FileTemplate
{

    public function __construct(SurveyAnswer $answer)
    {
        parent::__construct($answer);
    }

    public function saveFile($uploadedFile)
    {
        $name = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->extension();
        $size = $uploadedFile->getSize();

        $path = Storage::putFileAs('survey/' . $this->model->survey->id . '/' . $name,
            $uploadedFile, $name);

        $file = File::create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
        ]);

        $file->url = $this->getDownloadUrl($file,$file->path);
        $file->save();

        return $file;
    }

    protected function getDownloadUrl($file, $path)
    {
        return route('api.surveys.answers.download',
            [$this->model->survey->id, $this->model->id]);
    }

    /**
     * @inheritDoc
     */
    protected function getSavePath(string $fileName)
    {
        $answer = $this->model;
        return $path = '/survey/' . $this->model->survey->id . '/' . $fileName;
    }

    /**
     * @inheritDoc
     */
    protected function deleteFileInDB()
    {
        $answer = $this->model;
        $path = $answer->file->path;
        $answer->file->delete();
        return $path;
    }
}
