<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SectionStoreEmployeeRequest extends FormRequest
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
        $rules['id'] =  'required|min:5|max:25|unique:employees';
        $rules['name'] = 'required|regex:/^[a-zA-Z\s]*$/|min:3|max:150';
        $rules['gender_id'] = 'required|numeric|gt:0';
        $rules['birth_date'] = 'required|date';
        $rules['transfer_order_date'] = 'required|date';
        $rules['current_designation_id'] = 'required|numeric';
        $rules['current_office_id'] = 'required|numeric';
        $rules['lock_level'] = 'required|numeric';

        return $rules;
    }

    public function messages()
    {
        return [
            
        ];
    }
}
 

