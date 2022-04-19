<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오전 9:23
 */

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use App\Models\UserJobName;
use App\Services\Recruit\ApplyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class TestController extends Controller
{


    public function ndsrhkd()
    {
        $recruits = Recruit::all();
        return view('test.test-recommend', [
            'recruits' => $recruits
        ]);
    }

    public function ndsrhkdPost(Request $request, ApplyService $applyService)
    {
        $idList = $request->get('recruits', []);
        foreach ($idList as $recruitId) {
            try {
                $applyService->apply(Recruit::query()->findOrFail($recruitId), true);
            } catch (ModelNotFoundException $exception) {
                ddd();
            }
        }
    }
}
