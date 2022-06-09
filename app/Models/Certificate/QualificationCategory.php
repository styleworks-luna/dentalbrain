<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class QualificationCategory extends Model
{
    // 대한치과위생사협회, 대한치과의료관리학회
    const QUALIFICATION_CATEGORY_01 = 1;
    // 한국치위생감염관리학회
    const QUALIFICATION_CATEGORY_02 = 2;

    public function certificateQualifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificateQualification::class, 'category_id', 'id');
    }
}
