<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DevelopmentController extends Controller
{
    public function pretend(User $user)
    {
        Auth::loginUsingId($user->id);
        return redirect('/');
    }
}
