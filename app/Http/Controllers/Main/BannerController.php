<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Services\ViewCount\ViewCountImpl;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function redirectToLink(Banner $banner)
    {
        $viewCountIncrement = new ViewCountImpl();
        $viewCountIncrement->viewCountAdd($banner);
        return redirect($banner->link);
    }
}
