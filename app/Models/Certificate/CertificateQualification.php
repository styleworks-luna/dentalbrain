<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class CertificateQualification extends Model
{
    protected $guarded = [];

    public function certificateProfiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificateProfile::class, 'qualification_id', 'id');
    }
}
