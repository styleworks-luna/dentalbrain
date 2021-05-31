<?php

namespace App\Models\Program;

use App\Models\File;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @method static Builder main ()
 * @method static Builder Public (string|int|null $category = null, $orderBy = 'newest', $keyword = null)
 */
class Program extends Model
{
    use SoftDeletes;

    protected $table = 'programs';

    protected $appends = [
        'major_category_name',
        'minor_category_name',
        'user_like_cnt',
        'auth_like',
        'repeat_price',
    ];

    protected $guarded = [];

    protected $casts = [
        'is_online' => 'boolean',
        'is_open' => 'boolean',
    ];

    /*
     * ======= Custom Functions =========
     */

    public function canOnlineRefund()
    {
        $user = Auth::user();
        if ($this->alreadyPaid()) {
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->where('applied_at', '>', now()->subDays(7))
                ->where('is_watched', '=', 0)
                ->exists();
        } else {
            return false;
        }
    }

    /**
     * 이미 유저가 강의를 지불했는지 확인.
     * alreadyApplied > alreadyPaid
     * @param null $student
     * @return bool
     */
    public function alreadyPaid($student = null): bool
    {
        if (Auth::guest()) {
            return false;
        }

        if ($student != null) {
            return $student->expired_at > now()
                && ($student->pay_status == ProgramStudent::$PAY_PAID
                    || $student->pay_status == ProgramStudent::$PAY_ANOTHER_PAID
                );
        } else {
            $user = Auth::user();
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->whereIn('pay_status', [ProgramStudent::$PAY_PAID, ProgramStudent::$PAY_ANOTHER_PAID])
                ->where('expired_at', '>', now())
                ->exists();
        }
    }

    /**
     * 이미 유저가 강의를 신청했는지 확인.
     * alreadyApplied > alreadyPaid
     * @param null $student
     * @return bool
     */
    public function alreadyApplied($student = null): bool
    {
        if (Auth::guest()) {
            return false;
        }
        if ($student != null) {
            return $student->expired_at > now()
                && (
                    $student->pay_status == ProgramStudent::$PAY_IN_PROCESS
                    || $student->pay_status == ProgramStudent::$PAY_PAID
                    || $student->pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS
                    || $student->pay_status == ProgramStudent::$PAY_ANOTHER_PAID
                );
        } else {
            $user = Auth::user();
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->whereIn('pay_status', [
                    ProgramStudent::$PAY_PAID, ProgramStudent::$PAY_IN_PROCESS,
                    ProgramStudent::$PAY_ANOTHER_PAID, ProgramStudent::$PAY_ANOTHER_IN_PROCESS
                ])
                ->where('expired_at', '>', now())
                ->exists();
        }
    }

    /**
     *  입금 대기중인지 확인.
     *
     * @param null|ProgramStudent $student programStudent 정보가 존재 할 시에.
     * @return bool
     */
    public function waitDeposit($student = null): bool
    {
        if (Auth::guest()) {
            return false;
        }
        if ($student != null) {
            return $student->pay_status == ProgramStudent::$PAY_IN_PROCESS;
        } else {
            $user = Auth::user();
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->whereIn('pay_status', [ProgramStudent::$PAY_IN_PROCESS])
                ->exists();
        }

    }

    public function waitConfirmAnotherPay($student = null): bool
    {
        if (Auth::guest()) {
            return false;
        }
        if ($student != null) {
            return $student->pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS;
        } else {
            $user = Auth::user();
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->whereIn('pay_status', [ProgramStudent::$PAY_ANOTHER_IN_PROCESS])
                ->exists();
        }
    }

    public function canRepeat($student = null): bool
    {
        if ($this->is_online == false) {
            return false;
        }
        if (Auth::guest()) {
            return false;
        }
        if ($student != null) {
            return ($student->pay_status == ProgramStudent::$PAY_PAID
                    || $student->pay_status == ProgramStudent::$PAY_ANOTHER_PAID)
                && $student->expired_at < now();
        } else {
            $user = Auth::user();
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->whereIn('pay_status', [ProgramStudent::$PAY_PAID, ProgramStudent::$PAY_ANOTHER_PAID])
                ->where('expired_at', '<', now())
                ->exists();
        }
    }

    public function repeated($student = null): bool
    {
        if (Auth::guest()) {
            return false;
        }
        if ($student != null) {
            return $student->is_repeated == true;
        } else {
            $user = Auth::user();
            return $user->students()
                ->where('program_id', '=', $this->id)
                ->where('is_repeated', '=', true)
                ->exists();
        }
    }

    public function exceedCapacity()
    {
        return $this->place->capacity <= $this->students()
                ->whereIn('pay_status', [ProgramStudent::$PAY_PAID, ProgramStudent::$PAY_IN_PROCESS, ProgramStudent::$PAY_ANOTHER_PAID])
                ->count();
    }

    /*
     * ======= Define Relationships =========
     */

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, 'program_id', 'id');
    }

    /**
     * 오프라인 전용. 환불 요청 할 수 있는지 확인함.
     * @return bool
     */
    public function canRequestRefund()
    {
        return $this->place()->where('started_at', '>', now()->addDay())
            ->where('started_at', '<', now()->addDays(2))
            ->exists();
    }

    public function place()
    {
        return $this->hasOne(ProgramPlace::class, 'program_id', 'id');
    }

    public function majorCategory()
    {
        return $this->belongsTo(ProgramMajorCategory::class, 'major_category_id');
    }

    public function minorCategory()
    {
        return $this->belongsTo(ProgramMinorCategory::class, 'minor_category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'program_id', 'id');
    }

    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo(File::class, 'material_id', 'id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'program_id', 'id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'program_id', 'id');
    }

    public function like()
    {
        return $this->hasMany(UserLike::class, 'program_id', 'id')
            ->where('user_id', '=', Auth::id());
    }

    public function answers()
    {
        return $this->hasManyThrough(SurveyAnswer::class, Survey::class,
            'program_id', 'survey_id',
            'id', 'id');
    }


    /*
     * ======= Define Appended Attributes =========
     */

    public function getMajorCategoryNameAttribute()
    {
        if (isset($this->attributes['major_category_id']))
            return ProgramMajorCategory::find($this->attributes['major_category_id'])->name;
        else
            return null;
    }

    public function getMinorCategoryNameAttribute()
    {
        if (isset($this->attributes['minor_category_id']))
            return ProgramMinorCategory::find($this->attributes['minor_category_id'])->name;
        else
            return null;
    }

    public function getUserLikeCntAttribute()
    {
        return UserLike::query()->where('program_id', '=', $this->attributes['id'])->count();
    }

    public function getAuthLikeAttribute()
    {
        if (Auth::guest()) {
            return false;
        } else {
            return UserLike::query()
                ->where('program_id', '=', $this->attributes['id'])
                ->where('user_id', '=', Auth::id())->exists();
        }

    }

    public function getRepeatPriceAttribute()
    {
        $price = $this->attributes['price'] ?? 0;
        return $price * 7 / 10;
    }

    /*
     * ============== Scope ==============
     */
    public function scopeMain(Builder $query)
    {
        return $query->select(['id', 'thumbnail_id'])
            ->where('is_open', '=', 1)
            ->with('thumbnail:id,url')->orderByDesc('created_at');
    }

    public function scopePublic(Builder $query, $category = null, $orderBy = 'newest', $keyword = null)
    {
        $programs = $query->select([
            'id', 'thumbnail_id', 'is_online', 'major_category_id',
            'minor_category_id', 'title', 'running_time',
            'is_free', 'price'
        ])
            ->where('is_open', '=', 1)
            ->with(['thumbnail:id,url', 'place:id,program_id,started_at,ended_at'])
            ->withCount('students');

        if ($keyword != null) {
            $programs->where(/**
             * @param Builder $query
             */ function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });
        }

        if ($category !== null) {
            $programs = $programs->where('major_category_id', '=', $category);
        }

        if ($orderBy == 'popular') {
            $programs = $programs->orderByDesc('students_count');
        } else {
            $programs = $programs->orderByDesc('created_at');
        }

        return $programs;
    }
}
