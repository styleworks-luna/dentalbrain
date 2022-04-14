<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;

class RecruitSearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sido' => ['required', Rule::in(array_merge(RecruitSiDo::getArray(), ['all'])),],
            'order' => ['nullable', Rule::in(['newest', 'closest'])],
        ]);
        $sido = $validated['sido'];
        $order = $validated['order'] ?? 'newest';

        $builder = Recruit::query()->select('id', 'main_file_id', 'company_name', 'ended_at', 'sido', 'gugun')
            ->with([
                'file' => function ($query) {
                    $query->select('id', 'url', 'name');
                }
            ]);

        if ($sido != 'all') {
            $builder->where('sido', '=', $sido);
        }

        if ($order == 'newest') {
            $builder->orderBy('created_at', 'desc');
        } else {
            $builder->where('ended_at', '>=', now())
                ->orderBy('ended_at', 'ASC');
        }
        return response()->json($builder->paginate(12)->items());
    }
}
