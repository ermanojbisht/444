<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreInstanceRequest extends FormRequest
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

        
        Log::info($this->worktype_id);
        
        $rules['instance_type_id'] =  'required|numeric|gt:0';
        $rules['instance_name'] = 'required';
        return $rules;
    }

    public function messages()
    {

        return [
            'instance_type_id.gt:0' => 'Select Instance Type.'
        ];
    }
}
