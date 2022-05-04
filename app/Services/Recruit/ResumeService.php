<?php

namespace App\Services\Recruit;

use App\Models\File;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\Resume;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ResumeService
{
    public function getResumeValidator(array $data)
    {
        $privacyRules = [
            'work_area' => ['nullable', 'string', 'max:100',],
            'work_day' => ['nullable', 'string', 'max:100',],
            'work_time' => ['nullable', 'string', 'max:100',],
            'file_id' => ['required', 'numeric', 'min:1'],
            'name' => ['required', 'string', 'max:100',],
            'english_name' => ['required', 'string', 'max:100',],
            'birthday' => ['required', 'string', 'max:100',],
            'phone' => ['required', 'string', 'max:100',],
            'emergency_phone' => ['required', 'string', 'max:100',],
            'email' => ['required', 'email', 'max:100'],
            'address' => ['required', 'string', 'max:100',],
            'graduated_at' => ['nullable', 'string', 'max:100',],
            'school' => ['nullable', 'string', 'max:100',],
            'graduation_type' => ['nullable', 'string', 'max:100',],
            'about_me' => ['nullable', 'string', 'max:1000'],
        ];

        $certificateRules = [
            'certificate_name_1' => ['nullable', 'string', 'max:100'],
            'certificate_day_1' => ['nullable', 'string', 'max:100'],
            'certificate_agency_1' => ['nullable', 'string', 'max:100'],
            'certificate_name_2' => ['nullable', 'string', 'max:100'],
            'certificate_day_2' => ['nullable', 'string', 'max:100'],
            'certificate_agency_2' => ['nullable', 'string', 'max:100'],
            'certificate_name_3' => ['nullable', 'string', 'max:100'],
            'certificate_day_3' => ['nullable', 'string', 'max:100'],
            'certificate_agency_3' => ['nullable', 'string', 'max:100'],
            'certificate_name_4' => ['nullable', 'string', 'max:100'],
            'certificate_day_4' => ['nullable', 'string', 'max:100'],
            'certificate_agency_4' => ['nullable', 'string', 'max:100'],
            'certificate_name_5' => ['nullable', 'string', 'max:100'],
            'certificate_day_5' => ['nullable', 'string', 'max:100'],
            'certificate_agency_5' => ['nullable', 'string', 'max:100'],
        ];

        $jobPositionRules = [
            'treatment_1' => ['nullable', 'string', 'max:100',],
            'treatment_2' => ['nullable', 'string', 'max:100',],
            'treatment_3' => ['nullable', 'string', 'max:100',],
            'department_1' => ['nullable', 'string', 'max:100',],
            'department_2' => ['nullable', 'string', 'max:100',],
            'department_3' => ['nullable', 'string', 'max:100',],
        ];

        $careerRules = [
            'career_started_at_1' => ['nullable', 'string', 'max:100'],
            'career_ended_at_1' => ['nullable', 'string', 'max:100'],
            'career_company_1' => ['nullable', 'string', 'max:100'],
            'career_task_1' => ['nullable', 'string', 'max:100'],
            'career_started_at_2' => ['nullable', 'string', 'max:100'],
            'career_ended_at_2' => ['nullable', 'string', 'max:100'],
            'career_company_2' => ['nullable', 'string', 'max:100'],
            'career_task_2' => ['nullable', 'string', 'max:100'],
            'career_started_at_3' => ['nullable', 'string', 'max:100'],
            'career_ended_at_3' => ['nullable', 'string', 'max:100'],
            'career_company_3' => ['nullable', 'string', 'max:100'],
            'career_task_3' => ['nullable', 'string', 'max:100'],
            'career_started_at_4' => ['nullable', 'string', 'max:100'],
            'career_ended_at_4' => ['nullable', 'string', 'max:100'],
            'career_company_4' => ['nullable', 'string', 'max:100'],
            'career_task_4' => ['nullable', 'string', 'max:100'],
        ];

        return Validator::make($data, array_merge($privacyRules, $certificateRules, $jobPositionRules, $careerRules), [
            'required' => '필수로 작성하셔야 합니다.',
            'max' => ':max 자 이내로 입력해 주세요.'
        ]);
    }

    /**
     * @param Request $request
     * @return mixed|UploadedFile
     */
    public function validateFile(Request $request)
    {
        $validator = Validator::make($request->file(),
            ['image' => ['required', 'image', 'max:2048',]],
            ['image.max' => '이력서 사진을 2MB 아래로 제출해 주세요',]);
        $validator->validate();
        return $validator->validated()['image'];
    }

    /**
     * @return Builder|Model|object|null
     */
    public function getLoginUsersResume()
    {
        if (Auth::check() == false) {
            return null;
        }

        $userId = Auth::id();
        return Resume::query()->with(['file', 'user'])
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')->first();
    }

    public function existsResume(): bool
    {
        $userId = Auth::id();
        if (!Auth::check()) {
            return false;
        }
        return Resume::query()
            ->where('user_id', '=', $userId)
            ->exists();
    }

    public function searchForAdmin(?string $keyword)
    {
        $builder = Resume::query()->with('user:id,login_id,job_id');
        if ($keyword != null) {
            $builder->where(function ($query) use ($keyword) {
                $queryKey = "%${keyword}%";
                $query->orWhere('email', 'LIKE', $queryKey)
                    ->orWhere('name', 'LIKE', $queryKey)
                    ->orWhere('phone', 'LIKE', $queryKey)
                    ->orWhereHas('user', function (Builder $query) use ($queryKey) {
                        $query->where('login_id', 'LIKE', $queryKey);
                    });
            });
        }
        // 아이디 이메일 이름 전화번호
        return $builder
            ->select('id', 'user_id', 'name', 'phone', 'email')
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function getPdf(Resume $resume): \Barryvdh\DomPDF\PDF
    {
        $abilityAnswers = AbilityAnswer::onResume($resume)->get();

        $categories = AbilityCategory::query()->orderBy('seq')
            ->select(['id', 'seq', 'name'])
            ->get()
            ->mapWithKeys(function ($category) {
                return [$category['id'] => $category['name']];
            });

        $leftList = $abilityAnswers->filter(function ($answer) {
            return $answer->ability->category_id <= 5;
        });

        $rightList = $abilityAnswers->filter(function ($answer) {
            return $answer->ability->category_id > 5;
        });

        return Pdf::loadView('pdfs.resume_pdf', [
            'resume' => $resume,
            'leftList' => $leftList,
            'rightList' => $rightList,
            'categories' => $categories,
            'thumbnail' => $resume->file != null ? $this->encodeToBase64($resume->file) : '',
        ]);
    }

    private function encodeToBase64(File $file): string
    {
        $path = storage_path('app/' . $file->path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
