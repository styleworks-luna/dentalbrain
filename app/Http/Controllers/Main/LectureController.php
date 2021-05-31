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
            'order_by' => ['sometimes', 'required', Rule::in(['popular', 'newest'])],
            'keyword' => ['sometimes', 'required', 'string', 'min:2', 'max:200'],
        ]);

        $data = $v->validate();

        $keyword = $data['keyword'] ?? null;

        $orderBy = $data['order_by'] ?? 'newest';

        $programs = Program::public($data['category_id'], $orderBy, $keyword)->paginate($data['per_page']);

        return response()->json(
            $programs
        );
    }

    public function categories(Request $request)
    {
        return response()->json(ProgramMajorCategory::query()->orderBy('id')
            ->select(['id', 'name'])->get());
    }
}
