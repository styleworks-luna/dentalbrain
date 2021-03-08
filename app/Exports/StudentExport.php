<?php

namespace App\Exports;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentExport implements FromView
{
    use Exportable;


    private $program;

    /**
     * StudentExport constructor.
     * @param Program $program
     */
    public function __construct(Program $program)
    {
        $this->program = $program;
    }

//    /**
//     * @param mixed $programStudent
//     * @return array
//     */
//    public function map($programStudent): array
//    {
//        $surveyAnswers = array();
//        $newArray = array();
//        if (isset($programStudent->ticket->program->surveys)) {
//            foreach ($programStudent->ticket->program->surveys as $key => $value) {
//                if (isset($value->answers)) {
//                    foreach ($value->answers as $answerKey => $answerValue) {
//                        $data = null;
//                        switch ($value->category->eng_name) {
//                            case 'singleChoice':
//                            case 'multipleChoice' :
//                            case 'shortAnswer':
//                                $data = $answerValue['content'];
//                                break;
//                            case 'address':
//                                $data = $answerValue['address'] . ' ' . $answerValue['address_detail'];
//                                break;
//                            case 'file':
//                                $data = File::query()->find($answerValue['file_id'])->name;
//                                break;
//                            default:
//                                break;
//                        }
//                        if (isset($surveyAnswers[$value->question])) {
//                            $surveyAnswers[$value->question] .= ',' . $data;
//                        } else {
//                            $surveyAnswers[$value->question] = $data;
//                        }
//                    }
//                } else {
//                    $surveyAnswers[$value->question] = null;
//                }
//            }
//            unset($key, $value, $answerKey, $answerValue);
//            foreach ($surveyAnswers as $key => $value) {
//                array_push($newArray, $key, $value);
//            }
//            unset($surveyAnswers);
//        }
//
//        return array_merge([
//            $programStudent->id,
//            $programStudent->user->login_id,
//            $programStudent->email,
//            $programStudent->phone,
//            isset($programStudent->payment) ? $programStudent->payment->totalAmount : "미결제",
//            $programStudent->left_days . "일",
//            Carbon::createFromFormat('Y-m-d H:i:s', $programStudent->created_at)
//        ], $newArray);
//    }
//
//    /**
//     * @return Collection
//     */
//    public function collection()
//    {
//        return ProgramStudent::query()
//            ->select('id', 'ticket_id', 'user_id', 'email', 'phone', 'expired_at', 'created_at')
//            ->with(['ticket.program.surveys.answers', 'ticket.program.surveys.category', 'user:id,login_id', 'payment'])
//            ->has('user')
//            ->whereHas('ticket.program', function ($query) {
//                $query->where('id', $this->program->id);
//            })->orderBy('id', 'desc')->get();
//    }
//
//    /**
//     * 엑셀 헤더
//     *
//     * @return array
//     */
//    public function headings(): array
//    {
//        $surveyHeadings = $this->program->surveys()->whereNull('parent_id')
//            ->select('id', 'program_id', 'question')
//            // 순서 유지 중요!
//            ->orderBy('id')
//            ->get()->pluck('question');
//
//        return array_merge([
//            "번호",
//            "아이디",
//            "이메일",
//            "연락처",
//            "결제금액",
//            "시청기간",
//            "신청일시",
//        ], $surveyHeadings);
//    }

    public function view(): View
    {
        $surveys = $this->program->surveys()->whereNull('parent_id')
            // 순서 유지 중요!
            ->orderBy('id')
            ->withCount('choices')
            ->get();
        $students = ProgramStudent::query()->where('ticket_id', '=', $this->program->ticket->id)->get();
        $surveyAnswers = SurveyAnswer::query()->whereIn('survey_id', $surveys->pluck('id'))->get();
        return view('excels.students', [
            'surveys' => $surveys,
            'students' => $students,
            'surveyAnswers' => $surveyAnswers,
        ]);
    }
}
