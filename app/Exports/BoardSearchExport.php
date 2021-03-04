<?php

namespace App\Exports;

use App\Models\File;
use App\Models\Program\ProgramStudent;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BoardSearchExport implements FromCollection,WithMapping,withHeadings,ShouldAutoSize
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    private $program_id;


    public function __construct($program_id)
    {
        $this->program_id = $program_id;
    }

    public function map($programStudent): array
    {
        $surveyAnswers = array();
        $newArray = array();
        if(isset($programStudent->ticket->program->surveys)){
            foreach($programStudent->ticket->program->surveys as $key => $value) {
                if(isset($value->answers)){
                    foreach($value->answers as $answerKey => $answerValue){
                        $data = null;
                        switch($value->category->eng_name){
                            case 'singleChoice':
                                $data = $answerValue['content'];
                                break;
                            case 'multipleChoice' :
                                $data =  $answerValue['content'];
                                break;
                            case 'shortAnswer':
                                $data = $answerValue['content'];
                                break;
                            case 'address':
                                $data = $answerValue['address'].' '.$answerValue['address_detail'];
                                break;
                            case 'file':
                                $data = File::query()->find($answerValue['file_id'])->name;
                                break;
                            default:break;
                        }

                        if(isset($surveyAnswers[$value->question])){
                            $surveyAnswers[$value->question].= ','.$data;
                        }else{
                            $surveyAnswers[$value->question] = $data;
                        }
                    }
                }else{
                    $surveyAnswers[$value->question] = null;
                }
            }
            unset($key,$value,$answerKey,$answerValue);
            foreach($surveyAnswers as $key => $value){
                array_push($newArray,$key,$value);
            }
            unset($surveyAnswers);
        }

        return array_merge([
            $programStudent->id,
            $programStudent->user->login_id,
            $programStudent->email,
            $programStudent->phone,
            isset($programStudent->payment) ? $programStudent->payment->totalAmount: "미결제",
            $programStudent->left_days."일 남음",
            Carbon::createFromFormat('Y-m-d H:i:s', $programStudent->created_at)
        ],$newArray);
    }

    public function collection()
    {
        if(isset($this->program_id)){
            return ProgramStudent::query()
                ->select('id','ticket_id','user_id','email','phone','expired_at','created_at')
                ->with(['ticket.program.surveys.answers','ticket.program.surveys.category','user:id,login_id','payment'])
                ->has('user')
                ->whereHas('ticket.program',function($query){
                    $query->where('id',$this->program_id);
                })->orderBy('id','desc')->get();
        }
    }

    public function headings(): array
    {
        return [
            "번호",
            "아이디",
            "이메일",
            "연락처",
            "결제금액",
            "시청기간",
            "신청일시"
        ];
    }
}