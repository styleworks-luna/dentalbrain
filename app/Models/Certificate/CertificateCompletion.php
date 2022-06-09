<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Model;

class CertificateCompletion extends Model
{
    protected $guarded = [];

    public function certificateCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CompletionCategory::class, 'category_id', 'id');
    }
}
