<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class SecessionController extends Controller
{
    public function secessionForm()
    {
        return view(viewPrefix() . 'pages.user.mypage_secession');
    }

    public function secession()
    {

    }
}
