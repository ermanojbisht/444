<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmailRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeEmailController extends Controller
{
    public function edit()
    {
        //abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('auth.email.edit');
    }

    public function update(UpdateEmailRequest $request)
    {
        //first get whther email is requested to change
        $user=auth()->user();

        if(($request->email==$user->email)){
            return redirect()->route('employee.home')->with('message', 'No change requested');
        }

        auth()->user()->update($request->validated());
        $user->email_verified_at=null;
        $user->save();
        
        
        $user->sendEmailVerificationNotification();
      

        return redirect()->route('employee.home')->with('message', 'email updated , please verify your mail address through a link on your inbox');
    }
}
