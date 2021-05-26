<?php


namespace App\Services\Program;


use App\Models\File;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramMajorCategory;
use App\Models\Program\ProgramMinorCategory;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyCategory;
use App\Services\File\ProgramMaterial;
use App\Services\File\ProgramThumbnail;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    public function __construct($is_online)
    {
        $this->is_online = $is_online;
    }

    /**
     *  프로그램에 맞는 프로그램 구현체 반환
     *
     * @param Program|null $program
     * @return OfflineProgramConcrete|OnlineProgramConcrete
     */
    public static function getProgramConcrete(Program $program)
    {
        if ($program->is_online) {
            return new OnlineProgramConcrete();
        } else {
            return new OfflineProgramConcrete();
        }
    }

    function getProgramDetail(Program $program): array
    {
        return [
            'program' => $program->load('material:id,url,name', 'thumbnail:id,url,name'),
            'surveys' => $program->surveys()->select(['id', 'question', 'parent_id', 'category_id', 'is_required'])
                ->with('choices:id,question,parent_id')->get()
                ->whereNull('parent_id')->values()
        ];
    }

    /**
     * 강의 수강현황
     *
     * @param Program $program
     * @param $order
     * @return HasManyThrough
     */
    function getStudents(Program $program, $order)
    {
        $query = $program->students()
            ->select([
                'programs.program_id', 'programs.is_free',
                'program_students.id', 'program_students.pay_status', 'program_students.applied_at', 'program_students.payment_id', 'program_students.is_repeated',
                'payments.id', 'payments.totalAmount', 'payments.status', 'payments.method',
                'users.id', 'users.login_id', 'users.name', 'users.is_paid', 'users.email', 'users.phone'
            ])
            ->leftjoin('payments', 'payments.id', '=', 'program_students.payment_id')
            ->leftJoin('programs','program_id','=','program_students.program_id')
            ->join('users', 'users.id', '=', 'program_students.user_id');

        if ($order == 'latest') {
            $query->orderBy('program_students.id', 'DESC');
        } elseif ($order == 'login_id') {
            $query->orderBy('users.login_id', 'ASC');
        } elseif ($order == 'left_days') {
            $query->orderByRaw(DB::raw('CASE WHEN payments.status in ("CANCELED") THEN 0 ELSE 1 END DESC'));
            $query->orderBy('expired_at', 'desc');
        } else {
            $query->orderBy('program_students.id', 'DESC');
        }

        return $query;
    }


    /**
     * @return JsonResponse
     */
    static function getCategories(): JsonResponse
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
    static function changeOpenStatus(Program $program)
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
            'minor_category_id' => ['nullable', 'numeric'],
            'title' => ['required', 'string', 'max:200'],
            'thumbnail_id' => ['required', 'numeric'],
            'content' => ['required', 'string'],
            'is_open' => ['required', 'boolean'],
            'material_id' => ['sometimes', 'nullable', 'numeric'],

            'lecture_info' => ['required', 'string'],
            'is_free' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric'],
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

            'is_open' => $data['is_open'],
            'price' => $data['price'] ?? 0,
            'is_free' => $data['is_free'],
            'description' => $data['lecture_info'],
            //'term' => 100 days default.
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

        if ($data['is_free'] == true) {
            $data['price'] = 0;
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

            'price' => $data['price'] ?? 0,
            'is_free' => $data['is_free'],
            'name' => $data['lecture_info'],
            //'term' => 100 days default.
        ]);

        return $this->program;
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

    /**
     *  별도 결제 확인시에 호출하는 함수
     *
     * @param Program $program
     * @param ProgramStudent $student
     * @param $expired_at // 마감 기한
     * @return bool
     */
    public function confirmAnotherPay(Program $program, ProgramStudent $student, $expired_at): bool
    {
        try {
            DB::beginTransaction();
            // student 업데이트
            $student->updateWhenConfirmAnotherPay($program, $expired_at);

            // payment 업데이트
            /** @var Payment $payment */
            $payment = $student->payment()->first();
            $payment->updateWhenConfirmAnotherPay();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('CONFIRM ANOTHER PAY ERROR', [$exception, $program->id, $student, $expired_at]);
            return false;
        }

        DB::commit();
        return true;
    }
}
