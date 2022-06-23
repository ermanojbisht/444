<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreAddressRequest extends FormRequest
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
        $rules['address1'] = 'required|min:3|max:150';
        $rules['address_type_id'] = 'required|numeric|gt:0';
       
        $rules['state_id'] = 'required|numeric|gt:0';
        $rules['district_id'] = 'required|numeric|gt:0';
        $rules['tehsil_id'] = 'required|numeric|gt:0';
        $rules['vidhansabha_id'] = 'required|numeric|gt:0';
        $rules['updated_by'] =  'required';

        return $rules;
    }

    public function messages()
    {
        return [
            
        ]; 
    }
}
  

