<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-12
 * Time: 오전 11:18
 */
namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Manage\Notice;
use App\Http\Controllers\Controller;


class NoticeController extends Controller
{
    public function index()
    {
        return view(viewPrefix() . 'pages.service.notice', ['notice' =>Notice::orderBy('created_at','desc')->get()]);
    }

    public function show($number){
        $notice = Notice::findOrFail($number);
        return view(viewPrefix() . 'pages.service.notice_detail',['notice' => $notice]);
    }
}