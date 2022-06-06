<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StorePostingsRequest extends FormRequest
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
        $rules['employee_id'] =  'required|min:5|max:25';
        
        $rules['order_no'] =  'required';
        $rules['order_at'] =  'required';
        $rules['office_id'] =  'required|numeric';
        $rules['from_date'] =  'required|date';
        $rules['to_date'] =  'nullable|date';
        $rules['mode_id'] = 'required|numeric';
        $rules['designation_id'] = 'required|numeric';

        $rules['updated_by'] =  'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'aadhar.min:12' => 'Aadhar should be of 12 numbers.',
            'aadhar.max:12' => 'Aadhar should be of 12 numbers.'
        ];
    }
}
  

