<?php

namespace App\Models\Certificate;

use App\Models\File;
use App\Models\Program\Program;
use App\Models\User;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class QualificationProfile extends Model
{
    use HasCertificateStatus;

    protected $guarded = [];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function file(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }
}
