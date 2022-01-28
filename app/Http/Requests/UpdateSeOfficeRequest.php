<?php

namespace App\Http\Requests;

use App\Models\SeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('se_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'       => [
                'string',
                'min:3',
                'max:200',
                'required',
                'unique:se_offices,name,' . request()->route('se_office')->id,
            ],
            'name_h'     => [
                'string',
                'nullable',
            ],           
            'contact_no' => [
                'nullable',
                'integer',
                'min:1234567890',
                'max:9999999999',
            ],
            'lat'        => [
                'numeric',
            ],
            'lon'        => [
                'numeric',
            ],
            'ce_office_id'  => [
                'required',
                'integer'
            ],
        ];
    }
}
