<?php

namespace App\Http\Controllers\Admin\Program;

use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request, Program $program)
    {
        return Excel::download(new StudentExport($program), '전체 명단 엑셀.xlsx');
        //return Excel::download(new StudentExport($program), '전체 명단 엑셀.xlsx');
    }
}
