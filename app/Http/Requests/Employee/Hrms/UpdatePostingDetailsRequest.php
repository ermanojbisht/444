<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdatePostingDetailsRequest extends FormRequest
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
        $rules['id'] = 'required|numeric';
        $rules['employee_id'] =  'required|min:5|max:50';
        $rules['to_date'] =  'nullable|date';
        //$rules['order_no'] =  'required';
        //$rules['order_at'] =  'required|date';
        $rules['from_date'] =  'required|date';
        $rules['mode_id'] = 'required|numeric';
        $rules['office_id'] = 'required|numeric';
        $rules['designation_id'] = 'required|numeric';
        return $rules;
    }

    public function messages()
    {
        return [
            
        ];
    }
}
  

