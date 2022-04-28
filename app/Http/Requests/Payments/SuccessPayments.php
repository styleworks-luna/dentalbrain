<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;

class SuccessPayments extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'imp_uid' => ['required', 'string'],
            'merchant_uid' => ['required', 'string'],
        ];
    }

    /**
     * @return mixed
     */
    public function getImpUid(): ?string
    {
        $var = $this->get('imp_uid');
        if (!is_string($var)) {
            return null;
        }
        return $var;
    }

    /**
     * @return mixed
     */
    public function getMerchantUid(): ?string
    {
        $var = $this->get('merchant_uid');
        if (!is_string($var)) {
            return null;
        }
        return $var;
    }
}
