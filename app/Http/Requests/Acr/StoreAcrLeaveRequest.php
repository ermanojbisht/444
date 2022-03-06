<?php

namespace App\Http\Requests\Acr;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreAcrLeaveRequest extends FormRequest
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
        $rules['employee_id'] =  'required';
        $rules['type_id'] =  'required|numeric';
        $rules['from_date'] = 'required|date';
        $rules['to_date'] = 'required|date'; 

        return $rules;
    }

    public function messages()
    {

        return [
            
        ];
    }
}
