<?php

namespace App\DTO\Certification;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use Illuminate\Database\Eloquent\Model;

class ProgramCertificationDTO
{
    public $id;
    public $number;
    public $type;
    public $name;
    public $email;
    public $phone;
    public $birthday;
    public $university;
    public $student_number;
    public $status;

    /**
     * @param $id
     * @param $number
     * @param $type
     * @param $name
     * @param $email
     * @param $phone
     * @param $birthday
     * @param $university
     * @param $student_number
     * @param $status
     */
    protected function __construct($id, $number, $type, $name, $email, $phone, $birthday, $university, $student_number, $status)
    {
        $this->id = $id;
        $this->number = $number;
        $this->type = $type;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->birthday = $birthday;
        $this->university = $university;
        $this->student_number = $student_number;
        $this->status = $status;
    }

    /**
     * @throws \Exception
     */
    public static function create(Model $model, $number): ProgramCertificationDTO
    {
        if ($model instanceof QualificationProfile) {
            return self::createByQualification($model, $number);
        }
        if ($model instanceof CompletionProfile) {
            return self::createByCompletion($model, $number);
        }
        throw new \Exception("잘못된 model class 입니다.");
    }

    protected static function createByQualification(QualificationProfile $profileWithUser, $number): ProgramCertificationDTO
    {
        $user = $profileWithUser->user;
        return new ProgramCertificationDTO(
            $profileWithUser->id, $number, '자격증',
            $profileWithUser->name, $user->email, $user->phone, $profileWithUser->birthday,
            $profileWithUser->university, $profileWithUser->student_number, $profileWithUser->status);
    }

    protected static function createByCompletion(CompletionProfile $profileWithUser, $number)
    {
        $user = $profileWithUser->user;
        return new ProgramCertificationDTO(
            $profileWithUser->id, $number, '수료증',
            $profileWithUser->name, $user->email, $user->phone, $profileWithUser->birthday,
            $profileWithUser->university, $profileWithUser->student_number, $profileWithUser->status);
    }


}
