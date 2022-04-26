<?php

namespace App\Http\Controllers\Albatalk;

use App\Http\Controllers\Controller;
use App\Services\Recruit\HeadHuntingService;

class HeadHuntingController extends Controller
{
    private $headHuntingService;

    public function __construct(HeadHuntingService $headHuntingService)
    {
        $this->headHuntingService = $headHuntingService;
    }

    public function index()
    {
        return redirect($this->headHuntingService->getRedirectUrl());
    }
}
