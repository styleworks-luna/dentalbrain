<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-12
 * Time: 오전 11:18
 */
namespace App\Http\Controllers\Customer;

use App\Models\Manage\Notice;
use App\Http\Controllers\Controller;
use App\Interfaces\ViewCount\ViewCountImpl;

/**
 * Class NoticeController
 * @package App\Http\Controllers\Customer
 */

class NoticeController extends Controller
{
    private $dbName = 'notices';
    public function index()
    {
        return view(viewPrefix() . 'pages.service.notice', ['notice' =>Notice::orderBy('created_at','desc')->simplePaginate(10)]);
    }

    public function show(Notice $notice){
        $this->viewCountIncrement($notice);
        return view(viewPrefix() . 'pages.service.notice_detail',['notice' => $notice]);
    }

    public function viewCountIncrement(Notice $notice){
        $viewCountIncrement = new ViewCountImpl();
        $viewCountIncrement->viewCountAdd($notice);
    }
}