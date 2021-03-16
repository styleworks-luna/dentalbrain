<?php


namespace App\Services\Survey;


use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyAnswer;
use App\Models\Program\Survey\SurveyCategory;
use App\Services\File\SurveyFile;
use Illuminate\Support\Facades\Auth;

class SurveyAnswerService
{
    /**
     * 강의 설문 답변 validation
     *
     * @param array $surveyDataSet $request->all()
     * @return bool
     */
    public function validateSurveyAnswers(array $surveyDataSet): bool
    {
        foreach ($surveyDataSet as $idx => $data) {
            $survey = Survey::find($data['survey_id']);
            if ($survey->category_id == SurveyCategory::$SINGLE_CHOICE) {
                if ($survey->is_required && $data['answer'] === null) {
                    return false;
                }
            } elseif ($survey->category_id == SurveyCategory::$MULTIPLE_CHOICE) {
                if ($survey->is_required && $data['answers'] === null) {
                    return false;
                }
            } elseif ($survey->category_id == SurveyCategory::$SHORT_ANSWER) {
                if ($survey->is_required && $data['answer'] === null) {
                    return false;
                }
            } elseif ($survey->category_id == SurveyCategory::$ADDRESS) {
                if ($survey->is_required && $data['address'] === null) {
                    return false;
                }
            } elseif ($survey->category_id == SurveyCategory::$FILE) {
                if ($survey->is_required && $data['file'] === null && $data['previous'] === null) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * 강의 설문 답변 저장
     *
     * @param array $surveyDataSet $request->all()
     * @return bool
     */
    public function storeSurveyAnswers(array $surveyDataSet): bool
    {
        foreach ($surveyDataSet as $idx => $data) {
            $survey = Survey::find($data['survey_id']);

            $createData = [
                'survey_id' => $survey->id,
                'user_id' => Auth::id(),
            ];

            if ($survey->category_id == SurveyCategory::$SINGLE_CHOICE) {
                if ($data['answer'] === null) {
                    continue;
                }
                $createData['choice_id'] = $data['answer'];
                $createData['content'] = Survey::find($data['answer'])->question;
                SurveyAnswer::create($createData);

            } elseif ($survey->category_id == SurveyCategory::$MULTIPLE_CHOICE) {
                if ($data['answers'] === null) {
                    continue;
                }
                foreach ($data['answers'] as $answer) {
                    $createData['choice_id'] = $answer;
                    $createData['content'] = Survey::find($answer)->question;
                    SurveyAnswer::create($createData);
                }

            } elseif ($survey->category_id == SurveyCategory::$SHORT_ANSWER) {
                if ($data['answer'] === null) {
                    continue;
                }
                $createData['content'] = $data['answer'];

                SurveyAnswer::create($createData);

            } elseif ($survey->category_id == SurveyCategory::$ADDRESS) {
                if ($data['address'] === null) {
                    continue;
                }
                $createData['address'] = $data['address'];
                $createData['address_detail'] = $data['address_detail'];

                SurveyAnswer::create($createData);

            } elseif ($survey->category_id == SurveyCategory::$FILE) {
                if (!isset($data['file'])) {
                    continue;
                }
                if ($data['file'] === null) {
                    continue;
                }
                // 파일 만들기 부터
                $surveyAnswer = SurveyAnswer::create($createData);
                $surveyFileService = new SurveyFile($surveyAnswer);
                $file = $surveyFileService->saveFile($data['file']);
                $surveyAnswer->file_id = $file->id;
                $surveyAnswer->save();
            }
        }
        return true;
    }

    public function updateSurveyAnswers(array $surveyDataSet): bool
    {
        $this->deleteSurveyAnswers($surveyDataSet);
        return true;
    }

    public function deleteSurveyAnswers(array $surveyDataSet): bool
    {
        $ids = collect($surveyDataSet)->pluck('survey_id');

        $fileAnswers = SurveyAnswer::query()->whereIn('survey_id', $ids)
            ->where('user_id', '=', Auth::id())
            ->whereNotNull('file_id')->get();

        $surveyFiles = $fileAnswers->mapInto(SurveyFile::class);


        return true;
    }
}
