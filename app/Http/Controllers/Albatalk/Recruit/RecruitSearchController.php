<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecruitSearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sido' => ['nullable', 'array',],
            'sido.*' => ['string', Rule::in(RecruitSiDo::array()),],
            'order' => ['nullable', Rule::in(['newest', 'closest'])],
        ]);

        $sido = $validated['sido'] ?? RecruitSiDo::array();
        $order = $validated['order'] ?? 'newest';

        $builder = Recruit::query()->select('id', 'main_file_id', 'company_name', 'ended_at', 'sido', 'gugun')
            ->with([
                'file' => function ($query) {
                    $query->select('id', 'url', 'name');
                }
            ])->whereIn('sido', $sido)
            ->where('expired_at', '>=', now())
            ->where('is_open', Recruit::IS_OPEN);

        if ($order == 'newest') {
            $builder->orderBy('created_at', 'desc');
        } else {
            $builder->orderBy('ended_at');
        }
        return response()->json($builder->get());
    }
}
