<?php

namespace App\Http\Requests;

use App\Models\CeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ce_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'unique:ce_offices',
            ],
            'name_h'     => [
                'string',
                'required',
                'unique:ce_offices',
            ],
            'address'    => [
                'string',
                'nullable',
            ],
            'district'   => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'contact_no' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'lat'        => [
                'numeric',
            ],
            'lon'        => [
                'numeric',
            ],
        ];
    }
}
