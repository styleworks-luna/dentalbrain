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
        $isAcceptableSido = function ($attribute, $value, $fail) {
            $params = collect(explode(',', $value));
            $matched = $params->intersect(RecruitSiDo::getArray())->count() == $params->count();
            if (!$matched) {
                $fail('잘못된 입력값입니다.');
            }
        };

        $validated = $request->validate([
            'sido' => ['required', $isAcceptableSido,],
            'order' => ['nullable', Rule::in(['newest', 'closest'])],
        ]);
        $sido = explode(',', $validated['sido']);
        $order = $validated['order'] ?? 'newest';

        $builder = Recruit::query()->select('id', 'main_file_id', 'company_name', 'ended_at', 'sido', 'gugun')
            ->with([
                'file' => function ($query) {
                    $query->select('id', 'url', 'name');
                }
            ])->whereIn('sido', $sido);

        if ($order == 'newest') {
            $builder->orderBy('created_at', 'desc');
        } else {
            $builder->where('ended_at', '>=', now())
                ->orderBy('ended_at', 'ASC');
        }
        return response()->json($builder->paginate(12)->items());
    }
}
