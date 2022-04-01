<?php

namespace App\Services\Recruit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class AbilityService
{
    public function getValidatorOfAbilityAnswers(Collection $abilities, array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = $abilities->flatMap(function ($item, $key) {
            $id = $item->id;
            if ($item->type == 'select') {
                return [
                    'abilities.' . $id . '.score' => ['required', 'numeric', 'between:1,5'],
                    'abilities.' . $id . '.can_learn' => ['required', 'boolean']
                ];
            } else {
                return [
                    'abilities.' . $id . '.content' => ['required', 'string']
                ];
            }
        })->merge([
            'abilities' => ['array', 'required'],
        ]);

        $message = $abilities->flatMap(function ($item, $key) {
            $id = $item->id;
            if ($item->type == 'select') {
                return [
                    'abilities.' . $id . '.score.required' => '필수로 작성해야 합니다.',
                    'abilities.' . $id . '.score.numeric' => '잘못된 입력값입니다.',
                    'abilities.' . $id . '.score.between' => '필수로 작성해야 합니다.',
                    'abilities.' . $id . '.can_learn.required' => '입력되지 않았습니다.'
                ];
            } else {
                return [
                    'abilities.' . $id . '.content.required' => '작성해 주세요'
                ];
            }
        });

        return Validator::make($data, $rules->toArray(), $message->toArray());
    }
}
