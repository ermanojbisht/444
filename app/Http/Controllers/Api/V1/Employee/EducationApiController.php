<?php

namespace App\Http\Controllers\Api\V1\Employee;

use App\Http\Controllers\Controller;
use App\Models\Educationhrms;
use App\Models\User;
use App\Traits\ApiResponserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EducationApiController extends Controller
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
            $validator = Validator::make($request->all(), $this->educationValidationRules());
            if ($validator->passes()) {
                $data=[
                    'employee_id'=>$request->input('employee_id'),
                    'qualifiaction'=>$request->input('qualifiaction'),
                    'year'=>$request->input('year'),
                    'qualifiaction_type_id'=>$request->input('qualifiaction_type_id'),                   
                    'id'=>$request->input('id'),
                ];
                $education=Educationhrms::updateOrCreate(['id'=>$request->input('id')],$data);
               /* $education = new Educationhrms();
                $education->employee_id = $request->input('employee_id');
                $education->qualifiaction = $request->input('qualifiaction');
                $education->year = $request->input('year');
                $education->qualifiaction_type_id = $request->input('qualifiaction_type_id');
                $education->id = $request->input('id');
                $education->save();*/

                return $this->success($education, 'Education Created');
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
            $validator = Validator::make($request->all(), $this->educationValidationRules());
            if ($validator->passes()) {
                $education = Educationhrms::find($id);
                $education->employee_id = $request->input('employee_id');
                $education->qualifiaction = $request->input('qualifiaction');
                $education->year = $request->input('year');
                $education->qualifiaction_type_id = $request->input('qualifiaction_type_id');
                $education->save();

                return $this->success($education, 'Education Updated');
            }

            return $this->error($validator->errors(), 400);
        }

        return $this->error('Unauthorized Access', 401);
    }

    /**
     * @param CeOffice $ceOffice
     */
    public function destroy(Educationhrms $education)
    {
        $education->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    protected function educationValidationRules(): array
    {
        return [
            'employee_id' => 'required|string',
            'qualifiaction' => 'required|string',
            'year' => 'required|integer',
            'qualifiaction_type_id' => 'required|integer',
            'id' => 'required|integer'
        ];
    }
}
