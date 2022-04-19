<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오전 9:23
 */

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\UserJobName;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class TestController extends Controller
{
    public function showRegistrationForm()
    {
        return view('desktop.pages.dev.devRegister', [
            'jobs' => UserJobName::query()->orderBy('id')->get()
        ]);
    }
}
