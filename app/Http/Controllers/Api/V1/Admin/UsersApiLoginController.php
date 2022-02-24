<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponserTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsersApiLoginController extends Controller
{
    use ApiResponserTrait;

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $email = $request->email;
        $password = $request->password;
        try {
            if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
                $user = User::find(Auth::id());
                //$token = $user->createToken(config('site.tokenname'))->accessToken; //passport
                $token = $user->createToken(config('site.tokenname'))->plainTextToken; //sanctum
            } else {
                throw ValidationException::withMessages(
                    ['email' => ['not proper mail and password']]);
            }
        } catch (Exception $e) {
        }

        return $this->success([
            'token' => $token
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
