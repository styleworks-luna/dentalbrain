<?php


namespace App\Services\Survey;


use App\Models\Program\Program;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyAnswer;
use App\Models\Program\Survey\SurveyCategory;
use App\Models\User;
use App\Services\File\SurveyFile;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        foreach ($surveyDataSet as $idx => $data) {
            $survey = Survey::find($data['survey_id']);

            $columnData = [
                'survey_id' => $survey->id,
                'user_id' => Auth::id(),
            ];

            if ($survey->category_id == SurveyCategory::$SINGLE_CHOICE) {
                // 관련 정보 삭제.
                SurveyAnswer::where($columnData)->delete();
                if ($data['answer'] === null) {
                    continue;
                }
                $columnData['choice_id'] = $data['answer'];
                $columnData['content'] = Survey::find($data['answer'])->question;
                SurveyAnswer::create($columnData);

            } elseif ($survey->category_id == SurveyCategory::$MULTIPLE_CHOICE) {
                // 관련 정보 삭제.
                SurveyAnswer::where($columnData)->delete();
                if ($data['answers'] === null) {
                    continue;
                }
                foreach ($data['answers'] as $answer) {
                    $columnData['choice_id'] = $answer;
                    $columnData['content'] = Survey::find($answer)->question;
                    SurveyAnswer::create($columnData);
                }

            } elseif ($survey->category_id == SurveyCategory::$SHORT_ANSWER) {
                // 관련 정보 삭제.
                SurveyAnswer::where($columnData)->delete();
                if ($data['answer'] === null) {
                    continue;
                }
                $columnData['content'] = $data['answer'];

                SurveyAnswer::create($columnData);

            } elseif ($survey->category_id == SurveyCategory::$ADDRESS) {
                // 관련 정보 삭제.
                SurveyAnswer::where($columnData)->delete();
                if ($data['address'] === null) {
                    continue;
                }
                $columnData['address'] = $data['address'];
                $columnData['address_detail'] = $data['address_detail'];

                SurveyAnswer::create($columnData);

            } elseif ($survey->category_id == SurveyCategory::$FILE) {

                if (!$this->exists($data, 'file')) {
                    // 답변을 하지 않았을 경우.
                    continue;
                }

                if ($this->exists($data, 'previous')) {
                    // 기존 답변이 있었던 경우
                    $fileAnswer = SurveyAnswer::where($columnData)->first();
                    $surveyFileService = new SurveyFile($fileAnswer);
                    $surveyFileService->deleteFile();
                    $fileAnswer->delete();
                }

                // 파일 만들기 부터
                $surveyAnswer = SurveyAnswer::create($columnData);
                $surveyFileService = new SurveyFile($surveyAnswer);
                $file = $surveyFileService->saveFile($data['file']);
                $surveyAnswer->file_id = $file->id;
                $surveyAnswer->save();
            }
        }

        return true;
    }

    private function exists($array, $key): bool
    {
        if (!isset($array[$key])) {
            return false;
        }
        if ($array[$key] === null) {
            return false;
        }
        return true;
    }

    /**
     * @param Program $program
     * @param Authenticatable|User $user
     * @return bool
     */
    public static function deleteSurveyAnswersOfUser(Program $program, $user): bool
    {
        try {
            $surveyFiles = $program->answers()->where('user_id', '=', $user->id)
                ->whereNotNull('file_id')->get()->mapInto(SurveyFile::class);

            $surveyFiles->each(/* @param SurveyFile $surveyFile */ function ($surveyFile) {
                $surveyFile->deleteFile();
            });

            $program->answers()->where('user_id', '=', $user->id)->delete();

            return true;
        } catch (\Exception $exception) {
            Log::error('DELETE SURVEY ANSWERS ERROR', [$program, $user, $exception]);
            return false;
        }
    }
}
