<?php

namespace App\Http\Requests\Acr;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcrRequest extends FormRequest
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
        return [
            'employee_id'   => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'office_id' => 'required|numeric',
            'acr_type_id' => 'required|numeric',

            'property_filing_return_at' => 'required',
            'professional_org_membership' => 'nullable',
        ];
     
    }

    public function messages()
    {
        return [
            
        ];
    }
}
