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
use App\Interfaces\ViewCount\InterfaceViewCountImpl;

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

    public function show($id){
        $this->viewCountAdd($id);
        return view(viewPrefix() . 'pages.service.notice_detail',['notice' => Notice::findOrFail($id)]);
    }

    public function viewCountAdd(int $id){
        $viewCountIncrement = new InterfaceViewCountImpl();
        $viewCountIncrement->viewCountAdd($this->dbName,$id);
    }
}