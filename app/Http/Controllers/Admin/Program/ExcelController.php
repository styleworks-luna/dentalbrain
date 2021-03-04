<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\ProgramStudent;
use Illuminate\Http\Request;
use App\Exports\BoardSearchExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\HeadingRowImport;

class ExcelController extends Controller
{
    public function export(Request $request){
        return Excel::download(new BoardSearchExport($request->program_id), '전체 명단 엑셀.xlsx');
    }
}
