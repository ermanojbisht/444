<?php

namespace App\Http\Controllers\Api\V1\Employee;

use App\Http\Controllers\Controller;
use App\Models\Acr\Leave;
use App\Models\Educationhrms;
use App\Models\User;
use App\Traits\ApiResponserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LeaveApiController extends Controller
{
    use ApiResponserTrait;
    /**
     * @param  Request $request
     * @return mixed
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user(); //for ability need check on basis of user
        if (1 == 1) {
            $validator = Validator::make($request->all(), $this->leaveValidationRules());
            if ($validator->passes()) {
                $data=[
                    'employee_id'=>$request->input('employee_id'),
                    'type_id'=>$request->input('type_id'),
                    'from_date'=>$request->input('from_date'),
                    'to_date'=>$request->input('to_date'),                   
                    'id'=>$request->input('id'),
                ];
                Leave::updateOrCreate(['id'=>$request->input('id')],$data);
               /* $Leave = new Leave();
                $Leave->employee_id = $request->input('employee_id');
                $Leave->type_id = $request->input('type_id');
                $Leave->from_date = $request->input('from_date');
                $Leave->to_date = $request->input('to_date');
                $Leave->save();*/

                return $this->success($Leave, 'Leave Created');
            }

            return $this->error($validator->errors(), 400);
        }

        return $this->error('Unauthorized Access', 401);

        //return (new CeOfficeResource($ceOffice))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param  Request $request
     * @param  $id
     * @return mixed
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if (1 == 1) {
            $validator = Validator::make($request->all(), $this->leaveValidationRules());
            if ($validator->passes()) {
                $leave = Leave::find($id);
                $leave->employee_id = $request->input('employee_id');
                $leave->type_id = $request->input('type_id');
                $leave->from_date = $request->input('from_date');
                $leave->to_date = $request->input('to_date');
                $leave->save();

                return $this->success($leave, 'Leave Updated');
            }

            return $this->error($validator->errors(), 400);
        }

        return $this->error('Unauthorized Access', 401);
    }

    /**
     * @param CeOffice $ceOffice
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    protected function leaveValidationRules(): array
    {
        return [
            'employee_id' => 'required|string',
            'type_id' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date'
        ];
    }
}
