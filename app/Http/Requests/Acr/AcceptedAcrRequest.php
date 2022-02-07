<?php

namespace App\Http\Requests\Acr;

use Illuminate\Foundation\Http\FormRequest;

class AcceptedAcrRequest extends FormRequest
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
            'acr_id'   => 'required',
            'acr_agree' => 'required|numeric',
            'reason' => 'required_without_all:acr_agree',
            'marks' => 'required|numeric|min:1|max:100',
        ];
    }

    public function messages()
    {
        return [];
    }
}
