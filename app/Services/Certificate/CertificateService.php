<?php

namespace App\Services\Certificate;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Services\File\CertificateThumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\HasCertificateStatus;


class CertificateService
{
    public function getValidatorRecruit(Request $rawData, array $additionalRules = []): array
    {
        $validated = Validator::make($rawData->all(), array_merge([
            'file' => ['required'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['nullable', 'string', 'max:50'],
            'student_number' => ['nullable', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20'],
        ], $additionalRules));

        return $validated->validate();
    }

    public function createOrUpdateCompletionProfile(array $data, Program $program, $file)
    {
        $existProfile = CompletionProfile::query()->where('user_id', Auth::id())->where('program_id', $program->id)->first();

        $certificateThumbnail = new CertificateThumbnail($existProfile);
        $certificateThumbnail->deleteFile();

        if ($existProfile) {
            $existProfile->update([
                'user_id' => Auth::id(),
                'program_id' => $program->id,
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

    public function createOrUpdateQualificationProfile(array $data, Program $program, $file)
    {
        $existProfile = QualificationProfile::query()->where('user_id', Auth::id())->where('program_id', $program->id)->first();

        $certificateThumbnail = new CertificateThumbnail($existProfile);
        $certificateThumbnail->deleteFile();

        if ($existProfile) {
            $existProfile->update([
                'user_id' => Auth::id(),
                'program_id' => $program->id,
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
    private function updateCertificationProfiles(Program $program, int $userId)
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

    public function updateCertificationProfilesLoginUser(Program $program)
    {
        $this->updateCertificationProfiles($program, Auth::id());
    }

    public function updateCertificationProfile(Program $program, $userId)
    {
        $this->updateCertificationProfiles($program, $userId);
    }

    /**
     * @param Program $program
     * @param int|null $userId
     * @return void
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
}
