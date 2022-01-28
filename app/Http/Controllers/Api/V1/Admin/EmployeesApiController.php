<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class EmployeesApiController extends Controller {

    public function store(Request $request) {
        Log::info("this = " . print_r($request->all(), true));
        $employee = Employee::find($request->emp_code);
        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

}
