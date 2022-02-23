<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        //abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('auth.passwords.edit');
    }

    public function update(UpdatePasswordRequest $request)
    {
        //first get whther email is requested to change
        $user=auth()->user();

        if(($request->email===$user->email)){
            $emailChanged=false;
        }else{
            $emailChanged=true;
        }

        
        auth()->user()->update($request->validated());

        if($emailChanged){
            auth()->user()->update(['email_verified_at',Null]);
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('employee.home')->with('message', __('global.change_password_success'));
    }
}
