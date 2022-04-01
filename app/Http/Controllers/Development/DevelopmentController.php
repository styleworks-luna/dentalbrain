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
use App\Services\Recruit\AbilityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function dlstjd(Request $request)
    {
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
Lorem ipsum dolor sit amet, consect etur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cupiditate ducimus fugit illum iure labore, laudantium libero maiores odio optio quam quasi, qui quidem quod quos rem velit vitae voluptas?';


        $recruit->save();

        return view('emails.content')->with(
            [
                "title" => "제목",
                "content" => $recruit
            ]
        );
    }


    public function payment()
    {
        return view('test');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
//            'company_name' => ['required', 'string', 'max:255'],
//            'company_leader' => ['required', 'string', 'max:255'],
//            'company_license' => ['required', 'string', 'max:255'],
//            'company_phone' => ['required', 'numeric', 'between:9,11'],
//            'name' => ['required', 'string', 'max:255'],
//            'phone' => ['required', 'numeric', 'between:9,11'],
//            'email' => ['required', 'string', 'max:255'],
//            'url' => ['required', 'string', 'max:255'],
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['address'] = "서울 송파구 오금동";
        $validatedData['address_detail'] = "아남아파트";
        $validatedData['sido'] = "서울";
        $validatedData['gugun'] = "송파구";
        $validatedData['dong'] = "오금동";
        $validatedData['latitude'] = "37.50416961685561";
        $validatedData['longitude'] = "127.02096038259408";
        $validatedData['subway'] = "신논현 3번출구 도보 5분거리";
        $validatedData['career'] = "20";
        $validatedData['type_work_id'] = "1";
        $validatedData['type_job_id'] = "1";
        $validatedData['type_study_id'] = "1";
        $validatedData['started_at'] = "2022-03-29 15:32:32";
        $validatedData['ended_at'] = "2022-03-29 15:32:32";
        $validatedData['content'] = "안녕";


//        Recruit::firstOrCreate($validatedData);

        return redirect()->route('albatalk.payment');
    }

    public function getAbilities()
    {
        return view('desktop.pages.test.ability')->with([
            'leftList' => AbilityCategory::query()->where('id', '<=', '5')->with('abilities')->get(),
            'rightList' => AbilityCategory::query()->where('id', '>', '5')->with('abilities')->get()
        ]);
    }

    public function postAbilities(Request $request)
    {
        $validator = $this->abilityService->getValidatorOfAbilityAnswers(Ability::all(), $request->all());
        $data = $validator->validate();
        $collection = Collection::make($data['abilities']);
        $collection->each(function ($item, $key) {
            AbilityAnswer::query()->create([
                'ability_id' => $key,
                'score' => $item['score'] ?? null,
                'can_learn' => $item['can_learn'] ?? false,
                'content' => $item['content'] ?? null,
            ]);
        });
    }


}
