<?php


namespace App\Http\Controllers\Admin\Program;


use App\Models\Program\Program;
use Illuminate\Http\Request;

interface ProgramControllerInterface
{
    public function update(Request $request, Program $program);

    public function edit(Program $program);

    public function duplicateEdit(Program $program);

    public function duplicate(Request $request, Program $program);

    public function store(Request $request);

    function search(Request $request);
}
