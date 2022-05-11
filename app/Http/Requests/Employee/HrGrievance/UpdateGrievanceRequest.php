<?php

namespace App\Http\Requests\Employee\HrGrievance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateGrievanceRequest extends FormRequest
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
        $rules['grievance_type_id'] =  'required|numeric|gt:0';
        $rules['description'] = 'required';
        $rules['office_id'] = 'required|numeric';

        $rules['subject'] = 'required';
        $rules['employee_id'] = 'required';
        $rules['grievance_id'] = 'required';
        
        return $rules;
    }

    public function messages()
    {

        return [
            'grievance_type_id.gt:0' => 'Select Grievance Type.'
        ];
    }
}

// department_officials 
// transfer to other office 
// instruction draft and final 

//  4  and  5 => jobs office login 

