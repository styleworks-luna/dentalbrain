<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Recruit\AbilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevelopmentController extends Controller
{

    /**
     * @var AbilityService
     */
    private $abilityService;

    public function __construct(AbilityService $abilityService)
    {
        $this->abilityService = $abilityService;
    }

    public function pretend(User $user)
    {
        Auth::loginUsingId($user->id);
        return redirect('/');
    }

    public function show(Request $request)
    {
        $data = $request->session()->get('user');

        return view('emails.content')->with(
            [
                "title" => "session",
                "content" => json_encode($data)
            ]
        );
    }
}
