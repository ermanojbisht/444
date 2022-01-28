<?php

namespace App\Http\Requests;

use App\Models\CeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ce_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ce_offices,id',
        ];
    }
}
