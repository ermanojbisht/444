<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UsersApiLoginController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=> ['required','email'],
            'password'=> ['required']
        ]);
        $email=$request->email;
        $password=$request->password;
        try { if(Auth::attempt(['email'=>$email,'password'=>$password],true)){
            $user=User::find(Auth::id());
            $token = $user->createToken(config('site.tokenname'))->accessToken;
        }else{
           throw ValidationException::withMessages(
            ['email'=>['not proper mail and password']]);
        }

            
        } catch (Exception $e) {
            
        }
        return $token;
    }

 
}
