<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyAnswer;
use App\Models\Program\Survey\SurveyCategory;
use App\Services\File\SurveyFile;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplyController extends Controller
{
    public function showApplyForm(Program $program)
    {

        if ($program->answers()->where('user_id', '=', Auth::id())->exists()) {
            return redirect()->route('lectures.payment.form', $program->id);
        }

        if ($program->is_online == 1) {
            $programService = new OnlineProgramConcrete();
        } else {
            $programService = new OfflineProgramConcrete();
        }

        $programDetail = $programService->getProgramDetail($program);

        return view(viewPrefix() . 'pages.lecture.lecture_apply', [
            'program' => $programDetail['program'],
            'surveys' => $programDetail['surveys']
        ]);
    }

    public function apply(Request $request, Program $program)
    {
        // 파일을 함께 조회하기 위해 all 사용.
        $surveyDataSet = $request->all('surveys')['surveys'];

        try {
            DB::beginTransaction();

            $programStudent = ProgramStudent::updateOrCreate([
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
            ], [
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'applied_at' => now(),
            ]);

            if ($program->surveys()->doesntExist()) {
                return redirect()->route('lectures.payment.form', $program);
            }

            if ($this->validateSurveyAnswers($surveyDataSet) == false) {
                // Validation Failed.
                return redirect()->back(302)->with(['alert' => '필수 입력란을 작성해주세요.']);
            }


            foreach ($surveyDataSet as $idx => $data) {
                $survey = Survey::find($data['survey_id']);
                $this->storeSurveyAnswer($survey, $data);
            }

            if ($program->is_free) {
                // 무료 행사인 경우.
                $programStudent->expired_at = now()->addDays($program->ticket->term);
                $programStudent->save();

                return redirect()->route('lectures.result');
            }

            DB::commit();
        } catch (\Exception $exception) {
            Log::error('STORE SURVEY ANSWER ERROR', [$exception]);
            DB::rollback();
            return redirect()->back(302)->with(['alert' => '오류']);
        }
        return redirect()->route('lectures.payment.form', $program);
    }

    /**
     * 추가 질문사항 검증.
     *
     * @param $surveyDataSet
     * @return bool
     */
    private function validateSurveyAnswers($surveyDataSet)
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
                if ($survey->is_required && $data['file'] === null) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }


    /**
     * @param Survey $survey
     * @param $data
     * @return array|bool|SurveyAnswer false 면 오류. 배열이면 다중선택 질문. 보통 SurveyAnswer 모델 반환.
     */
    private function storeSurveyAnswer(Survey $survey, $data)
    {
        $createData = [
            'survey_id' => $survey->id,
            'user_id' => Auth::id(),
        ];

        $returnable = false;

        if ($survey->category_id == SurveyCategory::$SINGLE_CHOICE) {
            if ($data['answer'] === null) {
                return true;
            }
            $createData['choice_id'] = $data['answer'];
            $createData['content'] = Survey::find($data['answer'])->question;
            $returnable = SurveyAnswer::create($createData);

        } elseif ($survey->category_id == SurveyCategory::$MULTIPLE_CHOICE) {
            if ($data['answers'] === null) {
                return true;
            }
            $returnableDataSet = [];
            foreach ($data['answers'] as $answer) {
                $createData['choice_id'] = $answer;
                $createData['content'] = Survey::find($answer)->question;
                $returnableDataSet[] = SurveyAnswer::create($createData);
            }

            $returnable = $returnableDataSet;

        } elseif ($survey->category_id == SurveyCategory::$SHORT_ANSWER) {
            if ($data['answer'] === null) {
                return true;
            }
            $createData['content'] = $data['answer'];

            $returnable = SurveyAnswer::create($createData);

        } elseif ($survey->category_id == SurveyCategory::$ADDRESS) {
            if ($data['address'] === null) {
                return true;
            }
            $createData['address'] = $data['address'];
            $createData['address_detail'] = $data['address_detail'];

            $returnable = SurveyAnswer::create($createData);

        } elseif ($survey->category_id == SurveyCategory::$FILE) {
            if ($data['file'] === null) {
                return true;
            }
            // 파일 만들기 부터
            $surveyAnswer = SurveyAnswer::create($createData);
            $surveyFileService = new SurveyFile($surveyAnswer);
            $file = $surveyFileService->saveFile($data['file']);
            $surveyAnswer->file_id = $file->id;
            $surveyAnswer->save();

            $returnable = $surveyAnswer;
        }


        return $returnable;
    }

    public function result(Program $program)
    {
        $surveys = Survey::result($program->id)
            ->get();

        return view(viewPrefix() . 'pages.lecture.lecture_result', [
            'program' => $program,
            'surveys' => $surveys,
        ]);
    }
}
