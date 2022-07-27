<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

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
        // |unique:employees
        $rules['id'] =  'required|min:5|max:50';
        $rules['name'] = 'required|regex:/^[a-zA-Z\w\s].*$/|min:3|max:150';
        $rules['father_name'] = 'required|regex:/^[a-zA-Z\s]*$/|min:3|max:150';
        $rules['gender_id'] = 'required|numeric|gt:0';
        $rules['birth_date'] = 'required|date';
        $rules['retirement_date'] = 'required|date';
        $rules['phone_no'] = 'required|numeric|min:10';
        $rules['phone_no1'] = 'nullable|numeric|min:10';
        $rules['email'] = 'required|email';
        $rules['pan'] = 'nullable|regex:/^([A-Z]{3}[ABCFGHLJPTF]{1}[A-Z]{1}[0-9]{4}[A-Z]{1})$/';
        // $rules['aadhar'] = 'required|numeric|min:4';
        $rules['blood_group_id'] = 'required|numeric|gt:0';
        $rules['is_married'] = 'required|numeric|gt:0';
        $rules['cast_id'] = 'required|numeric|gt:0';
        $rules['benifit_category_id'] = 'required|gt:0';
        $rules['religion_id'] = 'required|numeric|gt:0';
        $rules['height'] = 'required|numeric|min:1';
        $rules['identity_mark'] = 'required';
        
        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}

// department_officials 
// transfer to other office 
// instruction draft and final 

//  4  and  5 => jobs office login 

