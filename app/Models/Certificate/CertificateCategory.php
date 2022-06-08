<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class CertificateCategory extends Model
{

    public function certificateQualifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificateQualification::class, 'category_id', 'id');
    }

    public function certificateCompletions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificateCompletion::class, 'category_id', 'id');
    }
}
