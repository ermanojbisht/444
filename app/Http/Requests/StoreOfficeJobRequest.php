<?php

namespace App\Http\Requests;

use App\Models\officeJob;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOfficeJobRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('office_job_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
