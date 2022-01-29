<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'name_h'   => ['string'],
            'email'    => ['required',  'email', 'max:255', 'unique:users,email,' . request()->route('user')->id],
            'roles.*'  => ['integer'],
            'roles'    => ['array'],
            'permissions.*' => [ 'integer',],
            'permissions'   => ['array',],
            'chat_id'  => ['integer','nullable',],
            'contact_no'  => ['integer','required',],
            'employee_id'     => ['string','nullable','unique:users,employee_id,' . request()->route('user')->id],
            'user_type'    => ['integer','nullable',],
        ];
    }
}
//42270313M02006
