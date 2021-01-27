<?php


namespace App\Services\Program;


use App\Models\Program\Lecture;
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
     * @param array $validatedDataSet
     * @return array
     */
    public function storeLectures($validatedDataSet)
    {
        $returnableDataSet = [];
        foreach ($validatedDataSet as $lecture) {
            $lecture['program_id'] = $this->program->id;
            $returnableDataSet[] = Lecture::create($lecture);
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
            'url' => ['required', 'link'],
            'file_id' => ['required'],
        ]);

        return $v->validate();
    }

    /**
     * @inheritDoc
     */
    function additionalRules()
    {
        // TODO: Implement additionalRules() method.
    }

    /**
     *
     *
     * @param Request $request
     */
    private function getLecturesFromRequest($request)
    {

    }
}
