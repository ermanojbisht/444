<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'phone_no' => 'numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:999999999',
            'chat_id' => [
                'required',
                'numeric',
                ' min:100000',
                Rule::unique('employees', 'chat_id')->ignore($this->employee)
            ]
        ];
    }

    public function messages()
    {
        return [
            'phone_no.required' => 'Phone no is required',
            'chat_id.required' => 'Telegram Id is required',
        ];
    }
}
