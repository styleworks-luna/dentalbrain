<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Services\Recruit\HeadHuntingService;
use Illuminate\Http\Request;

class HeadHuntingController extends Controller
{
    private $headHuntingService;

    public function __construct(HeadHuntingService $headHuntingService)
    {
        $this->headHuntingService = $headHuntingService;
    }

    public function create(Request $request)
    {
        $url = $this->headHuntingService->validate($request);
        $headHunting = $this->headHuntingService->create($url);

        return response()->json([
            'msg' => '작성되었습니다.',
            'url' => $headHunting->url,
        ]);
    }

    public function index()
    {
        $url = $this->headHuntingService->getRedirectUrl();
        return response()->json([
            'url' => $url
        ]);
    }
}
