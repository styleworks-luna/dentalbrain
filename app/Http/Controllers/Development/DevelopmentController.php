<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Recruit\Recruit;
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

    public function dlstjd(Request $request)
    {
//        $typeWork = new TypeWork();
//        $typeWork->type = '개발';
//        $typeWork->save();
//        $typeJob= new TypeJob();
//        $typeJob->type = '개발';
//        $typeJob->save();
//        $typeStudy = new TypeStudy();
//        $typeStudy->type = '개발';
//        $typeStudy->save();

        $recruit = new Recruit;

        $recruit->user_id = '1';
        $recruit->company_name = '온오프믹스';
        $recruit->company_leader = '강인성';
        $recruit->company_license = '123456789';
        $recruit->company_phone = '01012345678';
        $recruit->name = '강인성';
        $recruit->phone = '01012345678';
        $recruit->email = 'ins1106@onoffmix.com';
        $recruit->url = 'http://dbv2020.onoffmix.test';
        $recruit->address = '서울 서초구 논현동';
        $recruit->address_detail = '2동 101호';
        $recruit->latitude = '37.50416961685561';
        $recruit->longitude = '127.02096038259408';
        $recruit->career = '1';
        $recruit->type_work_id = '1';
        $recruit->type_job_id = '1';
        $recruit->type_study_id = '1';
        $recruit->started_at = '2022-03-29 15:32:32';
        $recruit->ended_at = '2022-03-29 15:32:32';
        $recruit->content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?';


        $recruit->save();

        return view('emails.content')->with(
            [
                "title" => "제목",
                "content" => $recruit
            ]
        );
    }
}
