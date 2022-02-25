<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Employee;
use App\Models\User;
use App\Traits\ApiResponserTrait;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;
use Symfony\Component\HttpFoundation\Response;

class UsersApiController extends Controller
{
    use ApiResponserTrait;
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }

    /**
     * @param StoreUserRequest $request
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param User $user
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
    }

    /**
     * @param UpdateUserRequest $request
     * @param User              $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param  Request $request
     * @return mixed
     */
    public function createUserFromEmployee(Request $request): JsonResponse
    {
        $loggeduser = $request->user(); //for ability need check on basis of user
        if (1 == 1) {
            $validator = Validator::make($request->all(), $this->userValidationRules());
            if ($validator->passes()) {
                $user=User::whereEmployeeId($request->input('employee_id'))->first();
                if($user){
                    return $this->error('employee_id='.$request->input('employee_id').' already exist as '.$user->name, 400);
                }
                $email = $this->checkMail($request->input('email'), $request->input('employee_id'));
                $user = new User();
                $user->employee_id = $request->input('employee_id');
                $user->name = $request->input('name');
                $user->email = $email;
                $user->contact_no = $request->input('contact_no');
                $user->password = Hash::make(config('site.defaultPass'));
                $user->user_type = 1;
                $user->approved = 1;
                $user->verified = 1;
                $user->verified_at = now();
                $user->save();

                return $this->success($user, 'User Created');
            }

            return $this->error($validator->errors(), 400);
        }

        return $this->error('Unauthorized Access', 401);
    }

    /**
     * @param  $email
     * @param  $employee_id
     * @return mixed
     */
    public function checkMail($email, $employee_id)
    {
        $isUserHavingMailExist = User::where('email', $email)->first();
        $isEmployeeHavingMailExist = Employee::where('c_email', $email)->first();
        if ($isUserHavingMailExist || $isEmployeeHavingMailExist || !$email) {
            //make new fake mail
            return $resultEmail = $employee_id.'@emp.com';
        }

        return $email;
    }

    protected function userValidationRules(): array
    {
        //'employee_id','name','email','contact_no'
        //`email_verified_at`,`password`,`user_type`,`approved`,`verified`,`verified_at`
        return [
            'employee_id' => 'required|string',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'contact_no' => 'nullable|integer'
        ];
    }
}
