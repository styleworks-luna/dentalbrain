<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class CertificateCompletion extends Model
{
    protected $guarded = [];

    public function certificateProfiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificateProfile::class, 'completion_id', 'id');
    }
}
