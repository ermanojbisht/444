<?php

namespace App\Http\Requests\Employee\Hrms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdatePostingsRequest extends FormRequest
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
        $rules['id'] =  'required';
        $rules['employee_id'] =  'required|min:5|max:50';
        $rules['to_date'] =  'required|date';
        $rules['updated_by'] =  'required';

        return $rules;
    }

    public function messages()
    {
        return [
            
        ];
    }
}
  

