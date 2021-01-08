<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        return view(viewPrefix() . 'pages.user.mypage_lecture');
    }
}
