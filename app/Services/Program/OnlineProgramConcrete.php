<?php


namespace App\Services\Program;


use App\Models\Program\Lecture;
use App\Models\Program\Program;
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
     * @param Program $program
     * @param array $dataSet
     * @return array
     */
    public function storeLectures(Program $program, $dataSet)
    {
        $returnableDataSet = [];
        foreach ($dataSet as $data) {
            $returnableDataSet[] = Lecture::create([
                'program_id' => $program->id,
                'thumbnail_id' => $data['file_id'] ?? null,
                'youtube_id' => Lecture::getYoutubeIdFromUrl($data['link']),
                'url' => $data['link'],
                'title' => $data['title'],
            ]);
        }
        return $returnableDataSet;
    }

    /**
     * Lecture validate
     *
     * @param Request $request
     * @return array
     */
    public function validateLectures($request)
    {
        $v = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'link' => ['required', 'url'],
            'file_id' => ['required'],
        ]);

        return $v->validate();
    }

    /**
     * @inheritDoc
     */
    function additionalRules()
    {
        return ['running_time' => ['required', 'string']];
    }
}
