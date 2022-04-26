<?php

namespace App\Services\Recruit;

use App\Models\Recruit\HeadHunting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeadHuntingService
{
    /**
     * @param string $url
     * @return HeadHunting
     */
    public function create(string $url): HeadHunting
    {
        $headHunting = new HeadHunting();
        $headHunting->url = $url;
        $headHunting->save();
        return $headHunting;
    }

    /**
     * @param Request $request
     * @return string|null
     */
    public function validate(Request $request): ?string
    {
        $validator = Validator::make($request->all(), [
            'url' => ['required', 'url'],
        ]);
        return $validator->validate()['url'];
    }

    public function getRedirectUrl(): ?string
    {
        return HeadHunting::query()->orderBy('created_at', 'DESC')->first()->url ?? '';
    }
}
