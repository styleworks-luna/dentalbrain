<?php

namespace App\Http\Controllers\Account;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\ProgramStudent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CertificateController
{
    public function certificatesData()
    {
        return ProgramStudent::query()
            ->select('program_students.id', 'program_students.user_id', 'program_students.payment_id', 'program_students.program_id', 'program_students.pay_status', 'program_students.applied_at',
                'payments.totalAmount as payments_totalAmount',

                'programs.title as programs_title',
                'programs.is_online as programs_is_online',
                'programs.running_time as programs_running_time',
                'programs.major_category_id as programs_major_category_id',
                'programs.minor_category_id as programs_minor_category_id',
                'programs.term as programs_term',
                'programs.qualification_id as programs_qualification_id',
                'programs.completion_id as programs_completion_id',

                'program_major_categories.name as programs_major_category_name',
                'program_minor_categories.name as programs_minor_category_name',

                'program_places.id as places_id',
                'program_places.address as places_address',
                'program_places.address_detail as places_address_detail',
                'program_places.sido as places_sido',
                'program_places.gugun as places_gugun',
                'program_places.started_at as places_started_at',
                'program_places.ended_at as places_ended_at',

                'files.id as thumbnail_id', 'files.path as thumbnail_path', 'files.url as thumbnail_url',

                'completion_profiles.id as completion_profiles_id', 'completion_profiles.status as completion_status',
                'qualification_profiles.id as qualification_profiles_id', 'qualification_profiles.status as qualification_status'
            )
            ->from('program_students')
            ->leftJoin('payments', 'payments.id', '=', 'program_students.payment_id')
            ->leftJoin('programs', 'program_students.program_id', '=', 'programs.id')
            ->leftJoin('program_places', 'programs.id', '=', 'program_places.program_id')
            ->leftJoin('files', 'programs.thumbnail_id', '=', 'files.id')
            ->leftJoin('completion_profiles', 'programs.id', '=', 'completion_profiles.program_id')
            ->leftJoin('qualification_profiles', 'programs.id', '=', 'qualification_profiles.program_id')
            ->join('program_major_categories', 'program_major_categories.id', '=', 'programs.major_category_id')
            ->join('program_minor_categories', 'program_minor_categories.id', '=', 'programs.minor_category_id')
            ->where('program_students.user_id', Auth::id())
            ->whereNotIn('program_students.pay_status', [ProgramStudent::$PAY_REFUNDED, ProgramStudent::$PAY_BEFORE])
            ->whereHas('program', function (Builder $query) {
                $query->whereNotNull('completion_id')->orWhereNotNull('qualification_id');
            })
            ->where('completion_profiles.status', '!=', CompletionProfile::$DO_NOT_PAID)
            ->orWhere('qualification_profiles.status', '!=', QualificationProfile::$DO_NOT_PAID)
            ->orderByDesc('applied_at')
            ->get()
            ->transform(function ($item, $key) {
                $item->time_in_string = $this->offlineProgramDateReset($item);
                return $item;
            })
            ->paginate(10);
    }

    function offlineProgramDateReset($item): ?string
    {
        if ($item->places_started_at == null || $item->places_ended_at == null) {
            return null;
        }
        $started_at = date('Y', strtotime($item->places_started_at)) . '년 ' . date('m', strtotime($item->places_started_at)) . '월 ' . date('d', strtotime($item->places_started_at)) . '일 ' . '(' . carbonDate($item->places_started_at, 'ddd') . ') ' . date('H:i', strtotime($item->places_started_at));
        $tilde = ' ~ ';
        $ended_at = date('Y', strtotime($item->places_ended_at)) . '년 ' . date('m', strtotime($item->places_ended_at)) . '월 ' . date('d', strtotime($item->places_ended_at)) . '일 ' . '(' . carbonDate($item->places_ended_at, 'ddd') . ') ' . date('H:i', strtotime($item->places_ended_at));

        return $started_at . $tilde . $ended_at;
    }
}

