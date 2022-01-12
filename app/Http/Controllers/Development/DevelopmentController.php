<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevelopmentController extends Controller
{
    public function pretend(User $user)
    {
        Auth::loginUsingId($user->id);
        return redirect('/');
    }

    public function ndsrhkd(Request $request)
    {
        return view('emails.content')->with(
            [
                "title" => "제목",
                "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?"
            ]
        );
    }
}
