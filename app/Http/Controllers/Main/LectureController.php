<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramMajorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        $v = Validator::make($request->all(), [
            'category_id' => ['required', Rule::exists('program_major_categories', 'id')],
            'per_page' => ['required', 'numeric'],
            'order_by' => ['sometimes', 'required', Rule::in(['popular', 'newest'])]
        ]);

        $data = $v->validate();

        // 기본값.
        $data['order_by'] = $data['order_by'] ?? 'newest';

        $programs = Program::public()
            ->where('major_category_id', '=', $data['category_id']);

        if ($data['order_by'] == 'popular') {
            // TODO: 인기순 정렬 만들기.
            $programs = $programs->inRandomOrder();
        } elseif ($data['order_by'] == 'newest') {
            $programs = $programs->orderByDesc('created_at');
        }

        $programs = $programs->paginate($data['per_page']);

        return response()->json(
            $programs
        );
    }

    public function categories(Request $request)
    {
        return response()->json(ProgramMajorCategory::query()->orderBy('id')->select(['id', 'name'])->get());
    }
}
