<?php

namespace App\Services\Certificate;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Services\File\CertificateThumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class CertificateService
{
    public function validator(Request $rawData): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($rawData->all(), [
            'file' => ['required', 'file', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['nullable', 'string', 'max:50'],
            'student_number' => ['nullable', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20', 'regex:/\d{4}\.\d{1,2}\.\d{1,2}/x'],
        ], [
            'file.max' => '파일이 너무 큽니다.',
            'file.required' => '증명서 사진이 필요합니다.',
            'name.max' => '이름이 너무 깁니다. 50자 이내로 수정해주세요.',
            'name.required' => '이름을 작성해 주세요.',
            'birthday.required' => '생년월일을 작성해 주세요.',
            'birthday.regex' => '생년월일이 형식에 맞지 않습니다.',
        ]);
    }

    public function createOrUpdateCompletionProfile(array $data, Program $program)
    {
        $file = CertificateThumbnail::saveFile($data['file']);

        $existProfile = CompletionProfile::query()
            ->where('user_id', Auth::id())
            ->where('program_id', $program->id)
            ->first();

        if ($existProfile) {
            $certificateThumbnail = new CertificateThumbnail($existProfile);
            $certificateThumbnail->deleteFile();

            $existProfile->update([
                'file_id' => $file->id,
                'name' => $data['name'],
                'university' => $data['university'],
                'student_number' => $data['student_number'],
                'birthday' => $data['birthday'],
                'status' => CompletionProfile::$DO_NOT_PAID,
            ]);
        } else {
            CompletionProfile::create([
                'user_id' => Auth::id(),
                'program_id' => $program->id,
                'file_id' => $file->id,
                'name' => $data['name'],
                'university' => $data['university'],
                'student_number' => $data['student_number'],
                'birthday' => $data['birthday'],
                'status' => CompletionProfile::$DO_NOT_PAID,
            ]);
        }
    }

    /**
     * @param array $data
     * @param Program $program
     */
    public function createOrUpdateQualificationProfile(array $data, Program $program)
    {
        $file = CertificateThumbnail::saveFile($data['file']);

        $existProfile = QualificationProfile::query()
            ->where('user_id', Auth::id())
            ->where('program_id', $program->id)
            ->first();

        if ($existProfile) {
            $certificateThumbnail = new CertificateThumbnail($existProfile);
            $certificateThumbnail->deleteFile();

            $existProfile->update([
                'file_id' => $file->id,
                'name' => $data['name'],
                'university' => $data['university'],
                'student_number' => $data['student_number'],
                'birthday' => $data['birthday'],
                'status' => QualificationProfile::$DO_NOT_PAID,
            ]);
        } else {
            QualificationProfile::create([
                'user_id' => Auth::id(),
                'program_id' => $program->id,
                'file_id' => $file->id,
                'name' => $data['name'],
                'university' => $data['university'],
                'student_number' => $data['student_number'],
                'birthday' => $data['birthday'],
                'status' => QualificationProfile::$DO_NOT_PAID,
            ]);
        }
    }

    /**
     * @param Program $program
     * @param int|null $userId
     * @return void
     */
    // 자격증 증명 정보 상태 대기로 변경
    private function updateToWaitingCertificationProfiles(Program $program, int $userId)
    {
        if ($userId == null) {
            $userId = Auth::id();
        }

        // 신청 후 상태 변경
        if ($program->completion_id) {
            CompletionProfile::query()
                ->where('user_id', $userId)
                ->where('program_id', $program->id)
                ->update(['status' => CompletionProfile::$WAITING,]);
        }
        if ($program->qualification_id) {
            QualificationProfile::query()
                ->where('user_id', $userId)
                ->where('program_id', $program->id)
                ->update(['status' => QualificationProfile::$WAITING,]);
        }
    }

    public function updateToWaitingCertificationProfilesLoginUser(Program $program)
    {
        $this->updateToWaitingCertificationProfiles($program, Auth::id());
    }

    public function updateToWaitingCertificationProfile(Program $program, $userId)
    {
        $this->updateToWaitingCertificationProfiles($program, $userId);
    }

    /**
     * @param Program $program
     * @param int|null $userId
     * @return void
     * @throws \Exception
     */
    // 환불 신청 후 증명 정보 삭제
    private function deleteCertifications(Program $program, int $userId)
    {
        if ($userId == null) {
            $userId = Auth::id();
        }

        // 환불 신청 후 증명정보 삭제
        if ($program->completion_id) {
            $completionProfile = CompletionProfile::query()
                ->where('program_id', $program->id)
                ->where('user_id', $userId)
                ->first();
            $certificateThumbnail = new CertificateThumbnail($completionProfile);
            $certificateThumbnail->deleteFile();
            $completionProfile->delete();
        }
        if ($program->qualification_id) {
            $qualificationProfile = QualificationProfile::query()
                ->where('program_id', $program->id)
                ->where('user_id', $userId)
                ->first();
            $certificateThumbnail = new CertificateThumbnail($qualificationProfile);
            $certificateThumbnail->deleteFile();
            $qualificationProfile->delete();
        }
    }

    public function deleteCertificationLoginUser(Program $program)
    {
        $this->deleteCertifications($program, Auth::id());
    }

    public function deleteCertification(Program $program, $userId)
    {
        $this->deleteCertifications($program, $userId);
    }

    /**
     * @param QualificationProfile $profile
     * @return int
     */
    public function getCertificationNumberForPassedQualification(QualificationProfile $profile): int
    {
        $count = QualificationProfile::query()->where('status', '=', QualificationProfile::$PASS)
            ->where('program_id', '=', $profile->program_id)
            ->where('user_id', '!=', $profile->user_id)
            ->count('id');

        $start = Program::query()
            ->leftJoin('certificate_qualifications as Q', 'Q.id', '=', 'programs.qualification_id')
            ->where('programs.id', '=', $profile->program_id)
            ->first('Q.certification_number')
            ->certification_number;

        return $start + $count;
    }

    public function passQualifications(Collection $ids): void
    {
        $collection = $ids->sort();
        $profile = QualificationProfile::find($collection->first());

        $startNumber = $this->getCertificationNumberForPassedQualification($profile);

        $collection->each(function ($item, $index) use ($startNumber) {
            DB::table('qualification_profiles')
                ->where('id', '=', $item)
                ->where('status', '!=', QualificationProfile::$PASS)
                ->update([
                    'certificate_number' => $startNumber + $index,
                    'status' => QualificationProfile::$PASS,
                    'passed_at' => now(),
                ]);
        });
    }

    public function passCompletions(Collection $ids): void
    {
        CompletionProfile::query()->whereIn('id', $ids->toArray())
            ->where('status', '!=', CompletionProfile::$PASS)
            ->update([
                'status' => CompletionProfile::$PASS,
                'passed_at' => now(),
            ]);
    }
}
