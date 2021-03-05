<?php


namespace App\Services\Program;


use App\Models\File;
use App\Models\Program\Program;
use App\Models\Program\ProgramMajorCategory;
use App\Models\Program\ProgramMinorCategory;
use App\Models\Program\ProgramStudent;
use App\Models\Program\ProgramTicket;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyCategory;
use App\Models\User;
use App\Payments\TossPayments\TossPayments;
use App\Services\File\ProgramMaterial;
use App\Services\File\ProgramThumbnail;
use App\Services\File\SurveyFile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

abstract class ProgramTemplate
{
    public $is_online;
    public $program = null;

    /**
     * ProgramTemplate constructor.
     * @param bool|int $is_online
     */
    public function __construct($is_online /*TODO Program 요구하도록 수정하기*/)
    {
        $this->is_online = $is_online;
    }

    function getProgramDetail(Program $program)
    {
        return [
            'program' => $program->load('material:id,url,name', 'thumbnail:id,url,name'),
            'ticket' => $program->tickets()->select(['id', 'name', 'price', 'is_free'])->get()->first(),
            'surveys' => $program->surveys()->select(['id', 'question', 'parent_id', 'category_id', 'is_required'])
                ->with('choices:id,question,parent_id')->get()
                ->whereNull('parent_id')->values()
        ];
    }

    /**
     * 강의 수강현황
     *
     * @param Program $program
     * @param int $perPage = 7
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function getStudents(Program $program, $perPage = 10,$order)
    {
         $query = $program->students()
             ->select([
                 'program_tickets.program_id','program_tickets.is_free',
                 'program_students.id','program_students.email','program_students.phone','program_students.pay_status','program_students.applied_at','program_students.payment_id',
                 'payments.id','payments.totalAmount','payments.status','payments.method',
                 'users.id','users.login_id','users.name'
             ])
             ->leftjoin('payments','payments.id','=','program_students.payment_id')
             ->join('users','users.id','=','program_students.user_id');

        if($order == 'latest'){
            $query->orderBy('program_students.id', 'DESC');
        }else if($order == 'login_id'){
            $query->orderBy('users.login_id', 'DESC');
        }else if($order == 'left_days'){
            $query->orderByRaw(DB::raw('CASE WHEN payments.status in ("CANCELED") THEN 0 ELSE 1 END DESC'));
            return collect($query->paginate($perPage))->sortByDesc('program_students.left_days');
        }else{
            $query->orderBy('program_students.id', 'DESC');
        }

        return $query->paginate($perPage);
    }


    /**
     * @return JsonResponse
     */
    function getCategories()
    {
        $major = ProgramMajorCategory::query()->select(['id', 'name'])->get();
        $minor = ProgramMinorCategory::query()->select(['id', 'name'])->get();
        return response()->json([
            'major' => $major,
            'minor' => $minor,
        ]);
    }

    /**
     * @param Program $program
     * @return Program
     */
    function changeOpenStatus(Program $program)
    {
        $program->is_open = !$program->is_open;
        $program->save();
        return $program;
    }

    /*
     * ========================= Validation =========================
     */

    /**
     * @param Request $request
     * @param array|null $additionalRules
     * @return array
     */
    function validateProgram(Request $request, array $additionalRules = [])
    {
        $v = Validator::make($request->all(), array_merge([
            'major_category_id' => ['required', 'numeric'],
            'minor_category_id' => ['required', 'numeric'],
            'title' => ['required', 'string', 'max:200'],
            'thumbnail_id' => ['required', 'numeric'],
            'content' => ['required', 'string'],
            'is_open' => ['required', 'boolean'],
            'material_id' => ['sometimes', 'nullable', 'numeric'],
        ], $additionalRules));

        return $v->validate();
    }

    function validateSurveys(Request $request, array $additionalRules = [])
    {
        $hasChoices = ['singleChoice', 'multipleChoice'];

        $validatedData = [];

        if ($request->get('surveys', false)) {
            $v = Validator::make($request->get('surveys', []), array_merge([
                '*.type' => ['required', Rule::exists('survey_categories', 'eng_name')],
                '*.question' => ['required', 'string'],
                '*.is_required' => ['required', 'boolean'],
                '*.choices' => ['sometimes', 'array', 'nullable',],
                '*.choices.*.question' => ['sometimes', 'required', 'string'],
            ], $additionalRules));

            $validatedData = $v->validate();
        }

        return $validatedData;
    }

    function validateTickets(Request $request, array $additionalRules = [])
    {
        // TODO: 가격 변경시에 신청자 있는지 체크하기.(필수)
        $v = Validator::make($request->all(), array_merge([
            'lecture_info' => ['required', 'string'],
            'is_free' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric'],
        ], $additionalRules));
        $validatedData = $v->validate();

        return $validatedData;
    }

    /*
     * ========================= STORE =========================
     */

    /**
     * 프로그램 생성.
     *
     * @param array $data
     * @return Program
     * @throws Exception 썸네일 저장 혹은 자료 저장 에러
     */
    function storeProgram(array $data)
    {
        $this->program = Program::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'is_online' => $this->is_online,
            'major_category_id' => $data['major_category_id'],
            'minor_category_id' => $data['minor_category_id'],
            'running_time' => $data['running_time'] ?? null,
            'thumbnail_id' => $data['thumbnail_id'],
            'material_id' => $data['material_id'] ?? null,
            'is_open' => $data['is_open']
        ]);

        $fileService = new ProgramThumbnail($this->program);
        if ($fileService->moveTempToPublic(File::find($data['thumbnail_id'])) === false) {
            throw new Exception('PROGRAM THUMBNAIL STORE ERROR');
        }

        if (isset($data['material_id'])) {
            $fileService = new ProgramMaterial($this->program);
            if ($fileService->moveTempToPublic(File::find($data['material_id'])) === false) {
                throw new Exception('PROGRAM MATERIAL STORE ERROR');
            }
        }

        return $this->program;
    }

    /**
     * @param Program $program
     * @param $data
     * @return mixed
     */
    function storeTickets(Program $program, $data)
    {
        return ProgramTicket::create([
            'price' => $data['price'] ?? 0,
            'is_free' => $data['is_free'],
            'name' => $data['lecture_info'],
            'program_id' => $program->id,
            //'term' => 100 days default.
        ]);
    }

    /**
     * @param Program $program
     * @param $dataSet
     * @return array
     */
    function storeSurveys(Program $program, $dataSet)
    {
        $returnableDataSet = [];
        foreach ($dataSet as $data) {
            $parent = Survey::create([
                'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                'program_id' => $program->id,
                'question' => $data['question'],
                'is_required' => $data['is_required'],
            ]);
            $returnableDataSet[] = $parent;
            if (SurveyCategory::hasChoices($data['type'])) {
                // 선택지가 있는 경우.
                foreach ($data['choices'] as $choice) {
                    $choice = Survey::create([
                        'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                        'program_id' => $program->id,
                        'question' => $choice['question'],
                        'is_required' => $data['is_required'],
                        'parent_id' => $parent->id,
                    ]);
                    $returnableDataSet[] = $choice;
                }
            }
        }
        return $returnableDataSet;
    }

    /*
     *  ========================= UPDATE =========================
     */

    function updateProgram(Program $program, array $data)
    {
        $this->program = $program;
        if ($data['thumbnail_id'] != $program->thumbnail->id) {
            // 썸네일이 변경된 경우.
            $fileService = new ProgramThumbnail($this->program);

            // 기존 파일 삭제
            $fileService->deleteFile();

            // 새로운 파일 등록
            $file = $fileService->moveTempToPublic(File::find($data['thumbnail_id']));
            if ($file === false) {
                throw new Exception('PROGRAM THUMBNAIL STORE ERROR');
            }
        }

        // material_id => sometimes 이기 때문.
        $data['material_id'] = isset($data['material_id']) ? $data['material_id'] : null;

        if ($program->material_id != $data['material_id']) {
            // 변경 있음.
            $fileService = new ProgramMaterial($program);
            if ($program->material()->exists()) {
                //기존 파일 삭제
                $fileService->deleteFile();
            }

            if ($data['material_id'] !== null) {
                // 새 파일 생성
                $file = $fileService->moveTempToPublic(File::find($data['material_id']));
                if ($file === false) {
                    throw new Exception('PROGRAM MATERIAL UPDATE ERROR');
                }
            }
        }

        $program->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'is_online' => $this->is_online,
            'major_category_id' => $data['major_category_id'],
            'minor_category_id' => $data['minor_category_id'],
            'running_time' => $data['running_time'] ?? null,
            'thumbnail_id' => $data['thumbnail_id'],
            'material_id' => $data['material_id'],
            'is_open' => $data['is_open'],
        ]);

        return $this->program;
    }

    public function updateTickets(Program $program, array $data)
    {
        if ($data['is_free'] == true) {
            $data['price'] = 0;
        }

        $program->tickets()->first()->update([
            'price' => $data['price'] ?? 0,
            'is_free' => $data['is_free'],
            'name' => $data['lecture_info'],
            //'term' => 100 days default.
        ]);
    }

    public function updateSurveys(Program $program, array $dataSet)
    {
        $returnableDataSet = [];
        $originalSurveyIds = $program->surveys()->pluck('id');

        foreach ($dataSet as $data) {
            if (isset($data['id'])) {
                // 기존에 존재하는 경우.
                $parent = Survey::find($data['id']);
                $parent->update([
                    'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                    'program_id' => $program->id,
                    'question' => $data['question'],
                    'is_required' => $data['is_required'],
                ]);
            } else {
                //새로 생성.
                $parent = Survey::create([
                    'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                    'program_id' => $program->id,
                    'question' => $data['question'],
                    'is_required' => $data['is_required'],
                ]);
            }
            $returnableDataSet[] = $parent;
            if (SurveyCategory::hasChoices($data['type'])) {
                // 선택지가 있는 경우.
                foreach ($data['choices'] as $choice) {
                    if (isset($choice['id'])) {
                        // 기존에 존재하는 경우.
                        $choice = Survey::find($choice['id']);
                        $choice->update([
                            'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                            'program_id' => $program->id,
                            'question' => $choice['question'],
                            'is_required' => $data['is_required'],
                            'parent_id' => $parent->id,
                        ]);
                    } else {
                        // 새로 생성한 항목인 경우.
                        $choice = Survey::create([
                            'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                            'program_id' => $program->id,
                            'question' => $choice['question'],
                            'is_required' => $data['is_required'],
                            'parent_id' => $parent->id,
                        ]);
                    }

                    $returnableDataSet[] = $choice;
                }
            }
        }
        // 삭제 된 설문조사들 삭제.
        $newSurveyIds = collect($returnableDataSet)->pluck('id');
        $deletable = $originalSurveyIds->diff($newSurveyIds);
        Survey::query()->whereIn('id', $deletable)->delete();

        return $returnableDataSet;
    }

    /*
     *  ========================= DELETE =========================
     */

    /**
     *  어드민 삭제 플로우
     *
     * @param Program $program
     * @param ProgramStudent $student
     * @param array $validatedData
     * @return boolean
     */
    public function cancel(Program $program, ProgramStudent $student, array $validatedData)
    {
        try {
            DB::beginTransaction();

            // 질문 답변 삭제 진행
            $builderOfSurveyAnswers = $program->answers()->where('user_id', '=', $student->user_id);

            //질문 답변 - 파일 삭제
            $surveyFiles = $builderOfSurveyAnswers->where('category_id', '=', SurveyCategory::$FILE)
                ->get()->mapInto(SurveyFile::class);

            $surveyFiles->map(function ($item, $key) {
                return $item->deleteFile();
            });

            $program->answers()->where('user_id', '=', $student->user_id)->delete();

            if ($program->ticket->is_free) {
                // 무료일 경우, 처리 끝.
                $student->pay_status = ProgramStudent::$PAY_BEFORE;
                $student->is_watched = 0;
                $student->expired_at = null;
                $student->save();

                DB::commit();
                return true;
            }
            // 유료일 경우,

            // 환불 상태 기록
            $student->pay_status = ProgramStudent::$PAY_REFUNDED;
            $student->is_watched = 0;
            $student->expired_at = null;
            $student->save();

            // 결제 취소 진행.
            $payment = $student->payment;
            $tossPayment = new TossPayments($payment->paymentKey);

            switch ($payment->method) {
                case '카드':
                    $response = $tossPayment->cancelCard($validatedData['reason']);
                    if ($response === false) {
                        DB::rollBack();
                        return false;
                    }
                    $payment->updateByToss($response);

                    DB::commit();
                    return true;
                case '가상계좌':
                    $response = $tossPayment->cancelVirtualAccount(
                        $validatedData['reason'], $validatedData['bank'], $validatedData['accountNumber'], $validatedData['holderName']
                    );
                    if ($response === false) {
                        DB::rollBack();
                        return false;
                    }
                    $payment->updateByToss($response);

                    DB::commit();
                    return true;
                //case '휴대폰':
                default:
                    DB::rollBack();
                    return false;
            }

        } catch (Exception $exception) {
            Log::error('CANCEL ERROR', [$exception]);
            DB::rollBack();
            return false;
        }

    }

    /**
     * @param Request $request
     * @param Program $program
     * @param User $user
     * @return array|false validated data
     */
    public function validateAdminCancel(Request $request, Program $program, User $user)
    {
        $base = $program->students()
            ->where('user_id', '=', $user->id)
            ->whereIn('pay_status', [ProgramStudent::$PAY_PAID,ProgramStudent::$PAY_IN_REFUND_PROCESS]);
        if ($base->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return false;
        }

        $student = $base->first();

        if ($program->ticket->is_free) {
            // 무료의 경우 reason 및 다른 params 필요없음
            // 더미 값.
            return ['reason' => '무료 강의 취소'];
        }
        $v = Validator::make($request->all(), [
            'reason' => ['required', 'string'],
        ])->sometimes(
        // 가상계좌의 경우, 은행, 예금주, 계좌번호가 필요함.
            ['bank', 'accountNumber', 'holderName'],
            ['required', 'string'],
            function ($input) use ($student) {
                return $student->payment->method == '가상계좌';
            });
        if ($v->fails()) {
            Log::debug('VALIDATE INFO', $v->failed());
            return false;
        }
        return $v->validated();
    }

    /**
     *  유저의 자동환불 요청 validation 하는 함수.
     *
     * @param Request $request
     * @param Program $program
     * @return array|false validated data, 실패시 false 리턴함.
     */
    public function validateUserCancel(Request $request, Program $program)
    {
        $base = $program->students()
            ->where('user_id', '=', Auth::id())
            ->where('pay_status', '=', ProgramStudent::$PAY_PAID);
        if ($base->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return false;
        }

        $student = $base->first();

        /*
//        if ($program->is_online) {
//            *  조건
//            *  # 온라인 강의
//            *      1. 7일 내
//            *      2. 강의 미 시청시. ( is_watched == 0)
//        } else {
//             *  # 오프라인 강의
//             *      1. 2일 전, 1일 안됨
//        }
        */

        if (!$student->cancelAvailable()) {
            return false;
        }

        if ($program->ticket->is_free) {
            return ['reason' => '무료 강의 취소 신청'];
        } else {
            $v = Validator::make($request->all(), [
                'reason' => ['required', 'string'],
            ])->sometimes(
            // 가상계좌의 경우, 은행, 예금주, 계좌번호가 필요함.
                ['bank', 'accountNumber', 'holderName'],
                ['required', 'string'],
                function ($input) use ($student) {
                    return $student->payment->method == '가상계좌';
                });

            return $v->validated();
        }
    }

    public function validateUserRequestCancel(Request $request, Program $program)
    {
        if ($program->is_online == 1) {
            return false;
        }

        $base = $program->students()
            ->where('user_id', '=', Auth::id())
            ->where('pay_status', '=', ProgramStudent::$PAY_PAID);
        if ($base->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return false;
        }

        $student = $base->first();

        if (!$program->canRequestRefund()) {
            return false;
        }

        if ($program->ticket->is_free) {
            return ['reason' => '무료 강의 취소 신청'];
        } else {
            $v = Validator::make($request->all(), [
                'reason' => ['required', 'string'],
            ])->sometimes(
            // 가상계좌의 경우, 은행, 예금주, 계좌번호가 필요함.
                ['bank', 'accountNumber', 'holderName'],
                ['required', 'string'],
                function ($input) use ($student) {
                    return $student->payment->method == '가상계좌';
                });

            return $v->validated();
        }
    }
}
