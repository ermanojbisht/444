<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'name_h'   => ['string'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required',],
            'roles.*'  => ['integer'],
            'roles'    => ['array'],
            'chat_id'  => ['integer'],
            'contact_no'  => ['integer'],
            'designation'  => ['string'],
            'remark'       => ['string'],
            'emp_code'     => ['string'],
            'user_type'    => ['integer'],
        ];
    }
}
