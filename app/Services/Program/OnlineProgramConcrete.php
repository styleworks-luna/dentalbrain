<?php


namespace App\Services\Program;


use App\Models\File;
use App\Models\Program\Lecture;
use App\Models\Program\Program;
use App\Services\File\LectureThumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnlineProgramConcrete extends ProgramTemplate
{
    public function __construct()
    {
        $is_online = true;
        parent::__construct($is_online);
    }


    /**
     * Lecture validate
     *
     * @param Request $request
     * @return array
     */
    public function validateLectures($request)
    {
        logger($request);
        $v = Validator::make($request->all(), [
            'lectures.*.title' => ['required', 'string'],
            'lectures.*.link' => ['required', 'url'],
            'lectures.*.thumbnail_id' => ['numeric', 'nullable'],
        ]);
        $validatedData = $v->validate();

        return $validatedData['lectures'];
    }

    /**
     * @param Program $program
     * @param array $dataSet
     * @return array
     */
    public function storeLectures(Program $program, $dataSet)
    {
        $returnableDataSet = [];
        foreach ($dataSet as $data) {
            $lecture = Lecture::create([
                'program_id' => $program->id,
                'thumbnail_id' => $data['thumbnail_id'] ?? null,
                'youtube_id' => Lecture::getYoutubeIdFromUrl($data['link']),
                'url' => $data['link'],
                'title' => $data['title'],
            ]);
            if (isset($data['thumbnail_id'])) {
                $fileService = new LectureThumbnail($lecture);
                $fileService->moveTempToPublic(File::find($data['thumbnail_id']));
            }
            $returnableDataSet[] = $lecture;

        }
        return $returnableDataSet;
    }


}
