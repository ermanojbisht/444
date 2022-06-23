<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SectionUpdateEmployeePostingRequest extends FormRequest
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
        $rules['designation_id'] = 'required|numeric|gt:0';
        $rules['id'] = 'required';
        $rules['transfer_order_date'] = 'required|date';
        $rules['is_office_head'] = 'required|numeric';
        $rules['is_designation_changed'] = 'required|numeric';
        $rules['is_office_changed'] = 'required|numeric';

        $rules['current_office_id'] = 'required_if:is_office_changed,==,1|numeric|gt:0';

        $rules['regular_incharge'] = 'required_if:is_designation_changed,==,1|numeric';
        $rules['current_designation_id'] = 'required_if:is_designation_changed,==,1|numeric|different:designation_id';

        return $rules;
    }

    public function messages()
    {
        return [];
    }
}

// department_officials 
// transfer to other office 
// instruction draft and final 

//  4  and  5 => jobs office login 
