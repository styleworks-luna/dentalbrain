<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\ProgramStudent;
use Illuminate\Http\Request;
use App\Exports\BoardSearchExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function export(Request $request){
        return Excel::download(new BoardSearchExport($request->is_online), 'qwer.xlsx');
    }
}
