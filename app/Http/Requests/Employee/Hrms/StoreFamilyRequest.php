<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreFamilyRequest extends FormRequest
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
        $rules['employee_id'] =  'required|min:5|max:50';
        $rules['relation_id'] = 'required|numeric|gt:0';
        $rules['name'] = 'required|min:3|max:150';
        $rules['birth_date'] = 'required||date';
        $rules['nominee_percentage'] = 'required|numeric|gt:0'; 
        $rules['updated_by'] =  'required';

        return $rules;
    }

    public function messages()
    {
        return [
            
        ];
    }
}
  

