<?php

namespace App\Services\Recruit;

use App\Models\Resume\Ability\Ability;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class AbilityService
{
    public function getDefaultRulesOfAbilityAnswers(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return $this->getRulesOfAbilityAnswers(Ability::all(), $data);
    }

    public function getRulesOfAbilityAnswers(Collection $abilities, array $rawData): \Illuminate\Contracts\Validation\Validator
    {
        $data = Collection::make($rawData)->map(function ($item, $key) {
            return array_merge($item, ['ability_id' => $key]);
        });

        $rules = $abilities->flatMap(function ($item, $key) {
            $id = $item->id;
            if ($item->type == 'select') {
                return [
                    $id . '.ability_id' => ['required', 'numeric',],
                    $id . '.score' => ['required', 'numeric', 'min:1', 'max:5'],
                    $id . '.can_learn' => ['required', 'boolean']
                ];
            } else {
                return [
                    $id . '.ability_id' => ['required', 'numeric',],
                    $id . '.content' => ['required', 'string']
                ];
            }
        });

        $message = $abilities->flatMap(function ($item, $key) {
            $id = $item->id;
            if ($item->type == 'select') {
                return [
                    $id . '.ability_id.required' => '잘못된 입력값입니다.',
                    $id . '.ability_id.numeric' => '잘못된 입력값입니다.',
                    $id . '.score.required' => '필수로 작성해야 합니다.',
                    $id . '.score.numeric' => '잘못된 입력값입니다.',
                    $id . '.score.min' => '항목을 선택해 주세요.',
                    $id . '.score.max' => '잘못된 입력값입니다.',
                    $id . '.can_learn.required' => '입력되지 않았습니다.'
                ];
            } else {
                return [
                    $id . '.ability_id.required' => '잘못된 입력값입니다.',
                    $id . '.ability_id.numeric' => '잘못된 입력값입니다.',
                    $id . '.content.required' => '작성해 주세요'
                ];
            }
        });

        return Validator::make($data->toArray(), $rules->toArray(), $message->toArray());
    }
}
