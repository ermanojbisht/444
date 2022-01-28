<?php

namespace App\Http\Requests;

use App\Models\EeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ee_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'         => [
                'string', 'min:3', 'max:200','required',
                'unique:ee_offices,name,' . request()->route('ee_office')->id,
            ],
            'name_h'       => [
                'string',  'nullable',
            ],
            'district'     => [
                'nullable',
                'string',
            ],
            'contact_no'   => [
                'nullable',
                'integer',
                'min:100000000',
            ],
            'lat'          => [
                'nullable','numeric',
            ],
            'lon'          => [
                'nullable','numeric',
            ],
            'se_office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
