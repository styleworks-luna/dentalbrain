<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오전 9:23
 */

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Models\Manage\BannerCategory;
use App\Models\Manage\Faq;
use App\Models\Manage\Inquiry;
use App\Models\Manage\Notice;
use App\Models\User;
use App\Models\UserJobName;
use App\Services\Notification\Sms\Ppurio;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function index()
    {
        //FAQ, 공지사항, 문의하기 생성 페이지
        return view(viewPrefix() . 'pages.test.create');
    }

    public function FaqEdit(Faq $faq)
    {
        return view(viewPrefix() . 'pages.test.testFaqUpdate', ['faq' => $faq]);
    }

    public function NoticeEdit(Notice $notice)
    {
        return view(viewPrefix() . 'pages.test.testNoticeUpdate', ['notice' => $notice]);
    }

    public function InquiryEdit(Inquiry $inquiry)
    {
        return view(viewPrefix() . 'pages.test.testInquiryUpdate', ['inquiry' => $inquiry]);
    }

    public function BannerEdit(Banner $banner){
        return view(viewPrefix().'pages.test.testBannerUpdate',['banner'=> $banner]);
    }

    public function FileUpload(Request $request)
    {
        return view(viewPrefix() . 'pages.test.testFileUpload');
    }

    public function UserEdit($userId){
        return view(viewPrefix(). 'pages.test.testUserUpdate',['user' => User::find($userId)]);
    }

    public function Search(){
        return view(viewPrefix(). 'pages.test.search',['bannerCategory' => BannerCategory::all(), 'userCategory' => UserJobName::all()]);
    }

    public function getToken(){
        $sms = new Ppurio();
        return $sms->getToken();
    }

    public function checkVerification(Request $request){
        $sms = new Ppurio();
        return $sms->checkVerification($request);
    }
}
