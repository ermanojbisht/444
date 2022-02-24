<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class UserTokenController extends Controller
{
    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            return $next($request);
        });
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {
        $optionsArray = ['' => 'select token type', 'hrms_entry' => 'hrms_entry'];

        return view('admin.token.create', compact('user', 'optionsArray'));
    }

    public function store(Request $request)
    {
        $user=User::find($request->user_id);
        if($user && $request->token_type){
            $token = $user->createToken($request->token_type)->plainTextToken; //sanctum
            return redirect()->route('admin.assignUserOffices',['userid'=>$user->id])->with('message','Please note down this token for further use. Token: '.$token);
        }
        return redirect()->back()->with('fail','There is some error please contact with administrator');
    }

    public function destroy(User $user)
    {
        $user->tokens()->delete();
        return redirect()->back()->with('message','Tokens has been deleted');
    }
}
