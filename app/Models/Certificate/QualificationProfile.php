<?php

namespace App\Models\Certificate;

use App\Models\File;
use App\Models\Program\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class QualificationProfile extends Model
{
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

    public static function updateStateAfterPaid(Program $program)
    {
        $certificateProfile = CompletionProfile::query()->where('user_id', Auth::id())
            ->where('program_id', $program->id)->first();

        $certificateProfile->update([
            'state' => CompletionProfile::WAITING,
        ]);

        return $certificateProfile;
    }
}
