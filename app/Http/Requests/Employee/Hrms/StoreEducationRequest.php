<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreEducationRequest extends FormRequest
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
        $rules['qualification_type_id'] = 'required|numeric|gt:0';  
        $rules['qualification_id'] = 'required|numeric';
        $rules['year'] = 'required|date_format:Y-m';  // 'required|numeric|min:1965|max:2999'; 
        $rules['updated_by'] =  'required'; 
        return $rules;
    }

    public function messages()
    {
        return [ ]; 
    }
}
  

