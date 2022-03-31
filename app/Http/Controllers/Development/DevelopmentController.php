<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Recruit\Recruit;
use App\Models\Resume\Ability\Ability;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DevelopmentController extends Controller
{
    public function pretend(User $user)
    {
        Auth::loginUsingId($user->id);
        return redirect('/');
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

    public function getAbilities()
    {
        return view('desktop.pages.test.ability')->with([
            'list' => AbilityCategory::query()->with('abilities')->get(),
        ]);
    }

    public function postAbilities(Request $request)
    {
        $validator = $this->validateAbility(Ability::all(), $request->all());
        $validator->validate();
    }

    private function validateAbility(Collection $abilities, array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = $abilities->flatMap(function ($item, $key) {
            $inputName = $item->input_name;
            if ($item->type == 'select') {
                return [
                    $inputName . '_score' => ['required', 'between:1,5'],
                    $inputName . '_can_learn' => ['required', 'boolean']
                ];
            } else {
                return [
                    $inputName . '_content' => ['required', 'string']
                ];
            }
        });

        return Validator::make($data, $rules->toArray());
    }
}
