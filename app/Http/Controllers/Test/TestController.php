<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오전 9:23
 */

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Manage\Faq;
use App\Models\Manage\Inquiry;
use App\Models\Manage\Notice;


class TestController extends Controller{
    public function index(){
        //FAQ, 공지사항, 문의하기 생성 페이지
        return view(viewPrefix() . 'pages.test.create');
    }

    public function FaqEdit(Faq $faq){
        return view(viewPrefix().'pages.test.testFaqUpdate',['faq'=>$faq]);
    }

    public function NoticeEdit(Notice $notice){
        return view(viewPrefix().'pages.test.testNoticeUpdate',['notice'=>$notice]);
    }

    public function InquiryEdit(Inquiry $inquiry){
        return view(viewPrefix().'pages.test.testInquiryUpdate',['inquiry'=>$inquiry]);
    }

}