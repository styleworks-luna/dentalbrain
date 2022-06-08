<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class CertificateQualification extends Model
{
    protected $guarded = [];

    public function certificateCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QualificationCategory::class, 'category_id', 'id');
    }
}
