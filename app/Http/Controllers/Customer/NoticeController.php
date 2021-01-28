<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-12
 * Time: 오전 11:18
 */

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\ViewCount\ViewCountImpl;
use App\Models\Manage\Notice;

/**
 * Class NoticeController
 * @package App\Http\Controllers\Customer
 */
class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::where('is_open',1)->orderBy('created_at', 'desc')->paginate(10);
        return view(viewPrefix() . 'pages.service.notice', ['notices' => $notices]);
    }

    public function show(Notice $notice)
    {
        $this->viewCountIncrement($notice);
        return view(viewPrefix() . 'pages.service.notice_detail', ['notice' => $notice]);
    }

    public function viewCountIncrement(Notice $notice)
    {
        $viewCountIncrement = new ViewCountImpl();
        $viewCountIncrement->viewCountAdd($notice);
    }
}
