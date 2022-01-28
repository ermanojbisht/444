<?php

namespace App\Http\Requests;

use App\Models\OfficeJobDefault;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOfficeJobDefaultRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('office_job_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ee_office_id' => [
                'integer',
                'required',
            ],
            'job_id' => [
                'integer',
                'required',
            ],
            'user_id' => [
                'integer',
                'required',
            ],
        ];
    }
}