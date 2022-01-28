<?php

namespace App\Http\Requests;

use App\Models\SeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('se_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'unique:se_offices',
            ],
            'name_h'     => [
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
            'ce_office'  => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
