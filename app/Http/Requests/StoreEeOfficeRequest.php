<?php

namespace App\Http\Requests;

use App\Models\EeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ee_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'         => [
                'string',
                'min:3',
                'max:200',
                'required',
                'unique:ee_offices',
            ],
            'name_h'       => [
                'string',
                'nullable',
            ],
            'district'     => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'contact_no'   => [
                'nullable',
                'integer',
                'min:10000000',
                'max:9999999999',
            ],
            'lat'          => [
                'numeric',
            ],
            'lon'          => [
                'numeric',
            ],
            'se_office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
