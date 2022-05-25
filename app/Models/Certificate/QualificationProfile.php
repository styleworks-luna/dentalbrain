<?php

namespace App\Models\Certificate;

use App\Models\File;
use App\Models\Program\Program;
use App\Models\User;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static QualificationProfile|Builder create(array $array)
 */
class QualificationProfile extends Model
{
    use HasCertificateStatus;

    protected $casts = [
        'is_issued' => 'boolean'
    ];

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
